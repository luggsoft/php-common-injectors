<?php

namespace CrystalCode\Php\Common\Injectors;

interface ArgumentInterface
{

    /**
     * 
     * @return mixed
     */
    function getValue();
    
    /**
     * 
     * @param ParameterInterface $parameter
     * @param mixed $value
     * @return bool
     */
    function tryResolveParameter(ParameterInterface $parameter, &$value = null): bool;

}
