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
     * @param string $name
     * @param mixed $value
     * @return DefinitionInterface
     */
    function withValue(string $name, $value): DefinitionInterface;

    /**
     *
     * @param array $values
     * @return DefinitionInterface
     */
    function withValues(array $values): DefinitionInterface;

    /**
     *
     * @param DefinitionInterface $definition
     * @return DefinitionInterface
     */
    function withDefinition(DefinitionInterface $definition): DefinitionInterface;

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    function withDefinitions(iterable $definitions): DefinitionInterface;

    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    function resolve(InjectorInterface $injector): object;

}
