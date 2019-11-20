<?php

namespace Luggsoft\Php\Common\Injectors;

final class ATest
{
    
    /**
     *
     * @var array
     */
    private $values = [];
    
    /**
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }
    
    /**
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }
    
    /**
     *
     * @param string $name
     * @return mixed
     */
    public function getValue(string $name)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }
        return null;
    }
    
}
