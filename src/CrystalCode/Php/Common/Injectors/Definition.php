<?php

namespace CrystalCode\Php\Common\Injectors;

use Iterator;
use ReflectionClass as ClassReflection;

final class Definition extends DefinitionBase
{

    /**
     *
     * @param string $className
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct($className, array $values = [], $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $values, $definitions);
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    protected function getInstance(InjectorInterface $injector)
    {
        $arguments = [];
        foreach ($this->getParameters() as $parameter) {
            $arguments[] = $this->resolveParameter($parameter, $injector);
        }
        $classReflection = $this->getClassReflection();
        if (!$classReflection->isInstantiable()) {
            throw new InjectorException(sprintf('Definition `%s` is not instantiable', $classReflection->getName()));
        }
        return $classReflection->newInstanceArgs($arguments);
    }

    /**
     *
     * @return Iterator|ParameterInterface[]
     */
    private function getParameters()
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
        if ($this->hasValue($name)) {
            return $this->getValue($name);
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
        throw new InjectorException(sprintf('Failed to resolve parameter `%s`', $name));
    }

}
