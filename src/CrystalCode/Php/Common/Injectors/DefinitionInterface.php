<?php

namespace CrystalCode\Php\Common\Injectors;

interface DefinitionInterface
{

    /**
     *
     * @return string
     */
    function getClassName(): string;

    /**
     * 
     * @return iterable|ArgumentInterface[]
     */
    function getArguments(): iterable;

    /**
     * 
     * @return iterable|DefinitionInterface[]
     */
    function getDefinitions(): iterable;

    /**
     * 
     * @param iterable|ArgumentInterface[] $arguments
     * @return DefinitionInterface
     */
    function withArguments(ArgumentInterface ...$arguments): DefinitionInterface;

    /**
     * 
     * @param iterable|DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    function withDefinitions(DefinitionInterface ...$definitions): DefinitionInterface;

    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    function resolve(InjectorInterface $injector): object;

}
