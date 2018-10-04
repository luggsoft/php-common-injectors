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
     * @return string
     */
    public function getName()
    {
        return $this->parameterReflection->getName();
    }

    /**
     *
     * @return string
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
     * @return bool
     */
    public function hasClassName()
    {
        return $this->parameterReflection->getClass() !== null;
    }

    /**
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->parameterReflection->getDefaultValue();
    }

    /**
     *
     * @return bool
     */
    public function hasDefaultValue()
    {
        return $this->parameterReflection->isDefaultValueAvailable();
    }

}
