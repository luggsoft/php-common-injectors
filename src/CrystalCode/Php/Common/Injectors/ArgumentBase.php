<?php

namespace CrystalCode\Php\Common\Injectors;

abstract class ArgumentBase implements ArgumentInterface
{

    /**
     *
     * @var mixed
     */
    private $value;

    /**
     * 
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function tryResolveParameter(ParameterInterface $parameter, &$value = null): bool
    {
        if ($this->canResolve($parameter)) {
            $value = $this->getValue();
            return true;
        }
        
        return false;
    }

    /**
     * 
     * @param ParameterInterface $parameter
     * @return bool
     */
    abstract public function canResolve(ParameterInterface $parameter): bool;

}
