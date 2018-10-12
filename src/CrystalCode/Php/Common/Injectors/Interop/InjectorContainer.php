<?php

namespace CrystalCode\Php\Common\Injectors\Interop;

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
     * @param type $id
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     */
    public function get($id, array $values = [], iterable $definitions = []): object
    {
        return $this->injector->create((string) $id, $values, $definitions);
    }

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return $this->injector->hasDefinition((string) $id);
    }

}
