<?php

namespace CrystalCode\Php\Common\Injectors;

abstract class DefinitionDecoratorBase implements DefinitionInterface
{

    /**
     *
     * @var DefinitionInterface
     */
    private $definition;

    /**
     *
     * @param DefinitionInterface $definition
     * @return void
     */
    public function __construct(DefinitionInterface $definition)
    {
        $this->definition = $definition;
    }

    /**
     *
     * @return DefinitionInterface
     */
    final public function getDefinition()
    {
        return $this->definition;
    }

    /**
     *
     * @return string
     */
    final public function getClassName()
    {
        return $this->definition->getClassName();
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return DefinitionInterface
     */
    final public function withValue($name, $value)
    {
        $this->definition = $this->definition->withValue($name, $value);
        return $this;
    }

    /**
     *
     * @param array $values
     * @return DefinitionInterface
     */
    final public function withValues(array $values)
    {
        $this->definition = $this->definition->withValues($values);
        return $this;
    }

    /**
     *
     * @param DefinitionInterface $definition
     * @return DefinitionInterface
     */
    final public function withDefinition(DefinitionInterface $definition)
    {
        $this->definition = $this->definition->withDefinition($definition);
        return $this;
    }

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    final public function withDefinitions($definitions)
    {
        $this->definition = $this->definition->withDefinitions($definitions);
        return $this;
    }

}
