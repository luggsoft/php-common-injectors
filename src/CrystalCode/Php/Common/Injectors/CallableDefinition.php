<?php

namespace CrystalCode\Php\Common\Injectors;

use \ReflectionClass as ClassReflection;

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
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(string $className, callable $callable, array $values = [], iterable $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $values, $definitions);
        $this->callable = $callable;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        $values = $this->getValues();
        $definitions = $this->getDefinitions();
        return $injector->call($this->callable, $values, $definitions);
    }

}
