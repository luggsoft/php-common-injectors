<?php

namespace CrystalCode\Php\Common\Injectors;

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
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct($className, callable $callable, array $values = [], $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $values, $definitions);
        $this->callable = $callable;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector)
    {
        $values = $this->getValues();
        $definitions = $this->getDefinitions();
        return $injector->call($this->callable, $values, $definitions);
    }

}
