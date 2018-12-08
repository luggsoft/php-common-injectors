<?php

namespace CrystalCode\Php\Common\Injectors;

final class InjectorBuilder extends InjectorBuilderBase
{

    /**
     * 
     * @param callable $callable
     * @return InjectorInterface
     */
    public static function buildFromCallable(callable $callable): InjectorInterface
    {
        $injectorBuilder = new InjectorBuilder();
        $callable($injectorBuilder);
        return $injectorBuilder->build();
    }

    /**
     * 
     * @param string $className
     * @param string $aliasName
     * @return InjectorBuilder
     */
    public function addAlias(string $className, string $aliasName): InjectorBuilder
    {
        $definition = new AliasDefinition($className, $aliasName);
        return $this->addDefinitions($definition);
    }

    /**
     * 
     * @param object $instance
     * @return InjectorBuilder
     */
    public function addInstance(object $instance): InjectorBuilder
    {
        $definition = new InstanceDefinition($instance);
        return $this->addDefinitions($definition);
    }

}
