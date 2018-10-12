<?php

namespace CrystalCode\Php\Common\Injectors;

final class ScopedInjector extends InjectorBase
{

    /**
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     * 
     * @param InjectorInterface $injector
     * @param iterable|DefinitionInterface[] $definitions
     */
    public function __construct(InjectorInterface $injector, iterable $definitions = [])
    {
        parent::__construct($definitions);
        $this->injector = $injector;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function create($className, array $values = [], iterable $definitions = []): object
    {
        if ($this->hasDefinition($className)) {
            return parent::create($className, $values, $definitions);
        }
        return $this->injector->create($className, $values, $definitions);
    }

}
