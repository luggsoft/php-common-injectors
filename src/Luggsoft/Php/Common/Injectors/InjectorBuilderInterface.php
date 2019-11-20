<?php

namespace Luggsoft\Php\Common\Injectors;

interface InjectorBuilderInterface
{
    
    /**
     *
     * @return InjectorInterface
     */
    function build(): InjectorInterface;
    
}
