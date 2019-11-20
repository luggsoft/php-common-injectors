<?php

namespace Luggsoft\Php\Common\Injectors;

use ReflectionClass as ClassReflection;

final class Definition extends DefinitionBase
{
    
    /**
     *
     * @param string $className
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     */
    public function __construct(string $className, iterable $arguments = [], iterable $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $arguments, $definitions);
    }
    
    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        $values = [];
        
        foreach ($this->getParameters() as $parameter) {
            $values[] = $this->resolveParameter($parameter, $injector);
        }
        
        $classReflection = $this->getClassReflection();
        
        if ($classReflection->isInstantiable() === false) {
            $message = vsprintf('Definition "%s" is not instantiable', [
                $classReflection->getName(),
            ]);
            throw new InjectorException($message);
        }
        
        return $classReflection->newInstanceArgs($values);
    }
    
    /**
     *
     * @return iterable|ParameterInterface[]
     */
    private function getParameters(): iterable
    {
        $classReflection = $this->getClassReflection();
        $callableReflection = $classReflection->getConstructor();
        
        if ($callableReflection === null) {
            return;
        }
        
        foreach ($callableReflection->getParameters() as $parameterReflection) {
            yield new Parameter($parameterReflection);
        }
    }
    
    /**
     *
     * @param ParameterInterface $parameter
     * @param InjectorInterface $injector
     * @return mixed
     * @throws InjectorException
     */
    private function resolveParameter(ParameterInterface $parameter, InjectorInterface $injector)
    {
        $name = $parameter->getName();
        
        if ($this->hasNamedArgument($name)) {
            return $this->getNamedArgument($name)->getValue();
        }
        
        $index = $parameter->getIndex();
        
        if ($this->hasIndexedArgument($index)) {
            return $this->getIndexedArgument($index)->getValue();
        }
        
        if ($parameter->hasClassName()) {
            $className = $parameter->getClassName();
            
            if ($this->hasDefinition($className)) {
                $definition = $this->getDefinition($className);
                
                return $definition->resolve($injector);
            }
            
            return $injector->create($className);
        }
        
        if ($parameter->hasDefaultValue()) {
            return $parameter->getDefaultValue();
        }
        
        $message = vsprintf('Failed to resolve parameter "%s"', [
            $name,
        ]);
        throw new InjectorException($message);
    }
    
}
