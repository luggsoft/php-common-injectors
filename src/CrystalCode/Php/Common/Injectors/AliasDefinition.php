<?php

namespace CrystalCode\Php\Common\Injectors;

use ReflectionClass as ClassReflection;

final class AliasDefinition extends DefinitionBase
{

    /**
     *
     * @var ClassReflection
     */
    private $aliasClassReflection;

    /**
     *
     * @param string $className
     * @param string $aliasName
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(string $className, string $aliasName, iterable $arguments = [], iterable $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $arguments, $definitions);
        $this->aliasClassReflection = new ClassReflection($aliasName);
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        $aliasName = $this->aliasClassReflection->getName();
        $arguments = $this->getArguments();
        $definitions = $this->getDefinitions();
        return $injector->create($aliasName, $arguments, $definitions);
    }

}
