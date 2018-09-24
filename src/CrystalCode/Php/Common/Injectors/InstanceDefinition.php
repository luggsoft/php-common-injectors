<?php

namespace CrystalCode\Php\Common\Injectors;

use ReflectionClass as ClassReflection;

final class InstanceDefinition extends DefinitionBase
{

    /**
     *
     * @var mixed
     */
    private $instance;

    /**
     *
     * @param mixed $instance
     * @return void
     */
    public function __construct($instance)
    {
        $classReflection = new ClassReflection($instance);
        parent::__construct($classReflection);
        $this->instance = $instance;
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    protected function getInstance(InjectorInterface $injector)
    {
        return $this->instance;
    }

}
