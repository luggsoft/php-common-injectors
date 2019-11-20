<?php

namespace Luggsoft\Php\Common\Injectors;

final class InstanceDefinitionDecorator extends DefinitionDecoratorBase
{
    
    /**
     *
     * @var object
     */
    private $instance;
    
    /**
     *
     * {@inheritdoc}
     */
    public function resolve(InjectorInterface $injector): object
    {
        if ($this->instance === null) {
            $definition = $this->getDefinition();
            $this->instance = $definition->resolve($injector);
        }
        
        return $this->instance;
    }
    
    /**
     *
     * @return void
     */
    public function clear(): void
    {
        $this->instance = null;
    }
    
}
