<?php

namespace Luggsoft\Php\Common\Injectors;

abstract class InjectorBuilderBase implements InjectorBuilderInterface
{
    
    /**
     *
     * @var array|ArgumentInterface[]
     */
    private $arguments = [];
    
    /**
     *
     * @var array|DefinitionInterface[]
     */
    private $definitions = [];
    
    /**
     *
     * @return InjectorInterface
     */
    final public function build(): InjectorInterface
    {
        return new Injector($this->definitions);
    }
    
    /**
     *
     * @param iterable|ArgumentInterface[] $arguments
     * @return InjectorBuilderBase
     */
    final public function addArguments(ArgumentInterface ...$arguments): InjectorBuilderBase
    {
        foreach ($arguments as $argument) {
            $this->arguments[] = $argument;
        }
        return $this;
    }
    
    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return InjectorBuilderBase
     */
    final public function addDefinitions(DefinitionInterface ...$definitions): InjectorBuilderBase
    {
        foreach ($definitions as $definition) {
            $this->definitions[] = $definition;
        }
        return $this;
    }
    
}
