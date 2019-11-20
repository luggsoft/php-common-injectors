<?php

namespace Luggsoft\Php\Common\Injectors;

final class NamedArgument extends ArgumentBase
{
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, $value)
    {
        parent::__construct($value);
        $this->name = $name;
    }
    
    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     *
     * {@inheritdoc}
     */
    public function canResolve(ParameterInterface $parameter): bool
    {
        return $this->name === $parameter->getName();
    }
    
}
