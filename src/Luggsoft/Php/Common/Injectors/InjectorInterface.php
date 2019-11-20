<?php

namespace Luggsoft\Php\Common\Injectors;

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
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     */
    function getDefinition(string $className, iterable $arguments = [], iterable $definitions = []): DefinitionInterface;
    
    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return InjectorInterface
     */
    function withDefinitions(DefinitionInterface ...$definitions): InjectorInterface;
    
    /**
     *
     * @param string $className
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     */
    function create(string $className, iterable $arguments = [], iterable $definitions = []);
    
    /**
     *
     * @param callable $callable
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     */
    function call(callable $callable, iterable $arguments = [], iterable $definitions = []);
    
}
