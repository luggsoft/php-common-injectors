<?php

namespace CrystalCode\Php\Common\Injectors;

final class InstanceDefinitionDecorator extends DefinitionDecoratorBase
{

    /**
     *
     * @var mixed
     */
    private $instance;

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    public function resolve(InjectorInterface $injector)
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
    public function clear()
    {
        $this->instance = null;
    }

}
