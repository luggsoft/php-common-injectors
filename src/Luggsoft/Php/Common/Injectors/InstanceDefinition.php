<?php

namespace Luggsoft\Php\Common\Injectors;

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
                $message = vsprintf('"instance" must be an instance of "%s"', [
                    $className,
                ]);
                throw new ArgumentException('instance', $message);
            }
        }
        
        $this->instance = $instance;
    }
    
    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        return $this->instance;
    }
    
}
