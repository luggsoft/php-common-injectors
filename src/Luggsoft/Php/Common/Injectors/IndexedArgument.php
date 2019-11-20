<?php

namespace Luggsoft\Php\Common\Injectors;

final class IndexedArgument extends ArgumentBase
{
    
    /**
     *
     * @var int
     */
    private $index;
    
    /**
     *
     * @param int $index
     * @param mixed $value
     */
    public function __construct(int $index, $value)
    {
        parent::__construct($value);
        $this->index = $index;
    }
    
    /**
     *
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }
    
    /**
     *
     * {@inheritdoc}
     */
    public function canResolve(ParameterInterface $parameter): bool
    {
        return $this->index === $parameter->getIndex();
    }
    
}
