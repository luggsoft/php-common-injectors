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
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(string $className, string $aliasName, array $values = [], iterable $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $values, $definitions);
        $this->aliasClassReflection = new ClassReflection($aliasName);
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getInstance(InjectorInterface $injector): object
    {
        $aliasName = $this->aliasClassReflection->getName();
        $values = $this->getValues();
        $definitions = $this->getDefinitions();
        return $injector->create($aliasName, $values, $definitions);
    }

}
