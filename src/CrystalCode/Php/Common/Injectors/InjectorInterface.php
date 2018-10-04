<?php

namespace CrystalCode\Php\Common\Injectors;

interface InjectorInterface
{

    /**
     * 
     * @param string $className
     * @return bool
     */
    function hasDefinition($className);

    /**
     * 
     * @param string $className
     * @param array $values
     * @param DefinitionInterface[] $definitions
     */
    function getDefinition($className, array $values = [], $definitions = []);

    /**
     *
     * @param DefinitionInterface $definition
     * @return InjectorInterface
     */
    function withDefinition(DefinitionInterface $definition);

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return InjectorInterface
     */
    function withDefinitions($definitions);

    /**
     *
     * @param string $className
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return mixed
     */
    function create($className, array $values = [], $definitions = []);

    /**
     *
     * @param callable $callable
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return mixed
     */
    function call(callable $callable, array $values = [], $definitions = []);

}
