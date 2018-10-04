<?php

namespace CrystalCode\Php\Common\Injectors;

interface DefinitionInterface
{

    /**
     *
     * @return string
     */
    function getClassName();

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return DefinitionInterface
     */
    function withValue($name, $value);

    /**
     *
     * @param array $values
     * @return DefinitionInterface
     */
    function withValues(array $values);

    /**
     *
     * @param DefinitionInterface $definition
     * @return DefinitionInterface
     */
    function withDefinition(DefinitionInterface $definition);

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    function withDefinitions($definitions);

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    function resolve(InjectorInterface $injector);

}
