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
    final public function getDefinition(): DefinitionInterface
    {
        return $this->definition;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function getClassName(): string
    {
        return $this->definition->getClassName();
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withValue(string $name, $value): DefinitionInterface
    {
        $this->definition = $this->definition->withValue($name, $value);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withValues(array $values): DefinitionInterface
    {
        $this->definition = $this->definition->withValues($values);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinition(DefinitionInterface $definition): DefinitionInterface
    {
        $this->definition = $this->definition->withDefinition($definition);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(iterable $definitions): DefinitionInterface
    {
        $this->definition = $this->definition->withDefinitions($definitions);
        return $this;
    }

}
