<?php

namespace CrystalCode\Php\Common\Injectors;

interface InjectorInterface
{

    /**
     * 
     * @param string $className
     * @return bool
     */
    function hasDefinition(string $className): bool;

    /**
     * 
     * @param string $className
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     */
    function getDefinition(string $className, array $values = [], iterable $definitions = []): DefinitionInterface;

    /**
     *
     * @param DefinitionInterface $definition
     * @return InjectorInterface
     */
    function withDefinition(DefinitionInterface $definition): InjectorInterface;

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return InjectorInterface
     */
    function withDefinitions(iterable $definitions): InjectorInterface;

    /**
     *
     * @param string $className
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     */
    function create(string $className, array $values = [], iterable $definitions = []);

    /**
     *
     * @param callable $callable
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     */
    function call(callable $callable, array $values = [], iterable $definitions = []);
}
