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
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct($className, $aliasName, array $values = [], $definitions = [])
    {
        $classReflection = new ClassReflection($className);
        parent::__construct($classReflection, $values, $definitions);
        $this->aliasClassReflection = new ClassReflection($aliasName);
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    protected function getInstance(InjectorInterface $injector)
    {
        $aliasName = $this->aliasClassReflection->getName();
        $values = $this->getValues();
        $definitions = $this->getDefinitions();
        return $injector->create($aliasName, $values, $definitions);
    }

}
