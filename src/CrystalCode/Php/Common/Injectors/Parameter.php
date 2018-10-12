<?php

namespace CrystalCode\Php\Common\Injectors;

use ReflectionParameter as ParameterReflection;

final class Parameter implements ParameterInterface
{

    /**
     *
     * @var ParameterReflection
     */
    private $parameterReflection;

    /**
     *
     * @param ParameterReflection $parameterReflection
     * @return void
     */
    public function __construct(ParameterReflection $parameterReflection)
    {
        $this->parameterReflection = $parameterReflection;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->parameterReflection->getName();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getClassName()
    {
        $classReflection = $this->parameterReflection->getClass();
        if ($classReflection === null) {
            return null;
        }
        return $classReflection->getName();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function hasClassName()
    {
        return $this->parameterReflection->getClass() !== null;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {
        return $this->parameterReflection->getDefaultValue();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function hasDefaultValue()
    {
        return $this->parameterReflection->isDefaultValueAvailable();
    }

}
