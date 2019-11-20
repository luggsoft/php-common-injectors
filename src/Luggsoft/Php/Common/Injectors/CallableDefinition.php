<?php

namespace Luggsoft\Php\Common\Injectors;

use ReflectionClass as ClassReflection;

final class CallableDefinition extends DefinitionBase
{
    
    /**
     *
     * @var callable
     */
    private $callable;
    
    /**
     *
     * @param string $className
     * @param callable $callable
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(string $className, callable $callable, array $arguments = [], iterable $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $arguments, $definitions);
        $this->callable = $callable;
    }
    
    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        $arguments = $this->getArguments();
        $definitions = $this->getDefinitions();
        return $injector->call($this->callable, $arguments, $definitions);
    }
    
}
