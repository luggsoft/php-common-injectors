<?php

namespace Luggsoft\Php\Common\Injectors;

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
    public function getName(): string
    {
        return $this->parameterReflection->getName();
    }
    
    /**
     *
     * {@inheritdoc}
     */
    public function getIndex(): int
    {
        return $this->parameterReflection->getPosition();
    }
    
    /**
     *
     * {@inheritdoc}
     */
    public function getClassName(): string
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
    public function hasClassName(): bool
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
    public function hasDefaultValue(): bool
    {
        return $this->parameterReflection->isDefaultValueAvailable();
    }
    
    /**
     *
     * {@inheritdoc}
     */
    public function tryResolveArgument(ArgumentInterface $argument, &$value = null): bool
    {
        return $argument->tryResolveParameter($this, $value);
    }
    
}
