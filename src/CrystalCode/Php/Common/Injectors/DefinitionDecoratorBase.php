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
    final public function getArguments(): iterable
    {
        return $this->definition->getArguments();
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getDefinitions(): iterable
    {
        return $this->definition->getDefinitions();
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withArguments(ArgumentInterface ...$arguments): DefinitionInterface
    {
        $this->definition = $this->definition->withArguments($arguments);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(DefinitionInterface ...$definitions): DefinitionInterface
    {
        $this->definition = $this->definition->withDefinitions($definitions);
        return $this;
    }

}
