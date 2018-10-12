<?php

namespace CrystalCode\Php\Common\Injectors;

use Exception;
use ReflectionClass as ClassReflection;

final class InstanceDefinition extends DefinitionBase
{

    /**
     *
     * @var object
     */
    private $instance;

    /**
     *
     * @param object $instance
     * @param string $className
     */
    public function __construct(object $instance, string $className = null)
    {
        if ($className === null) {
            $classReflection = new ClassReflection($instance);
            parent::__construct($classReflection);
        }
        else {
            if ($instance instanceof $className) {
                $classReflection = new ClassReflection($className);
                parent::__construct($classReflection);
            }
            else {
                throw new Exception();
            }
        }
        $this->instance = $instance;
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    protected function getInstance(InjectorInterface $injector):object
    {
        return $this->instance;
    }

}
