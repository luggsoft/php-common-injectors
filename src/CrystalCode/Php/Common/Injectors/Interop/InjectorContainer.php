<?php

namespace CrystalCode\Php\Common\Injectors\Interop;

use CrystalCode\Php\Common\Injectors\ArgumentInterface;
use CrystalCode\Php\Common\Injectors\DefinitionInterface;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use Psr\Container\ContainerInterface;

final class InjectorContainer implements ContainerInterface
{

    /**
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     * 
     * @param InjectorInterface $injector
     */
    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }

    /**
     * 
     * {@inheritdoc}
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     */
    public function get($id, iterable $arguments = [], iterable $definitions = []): object
    {
        return $this->injector->create((string) $id, $arguments, $definitions);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function has($id): bool
    {
        return $this->injector->hasDefinition((string) $id);
    }

    /**
     * 
     * @return InjectorInterface
     */
    public function getInjector(): InjectorInterface
    {
        return $this->injector;
    }

}
