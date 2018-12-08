<?php

namespace CrystalCode\Php\Common\Injectors;

interface InjectorBuilderInterface
{

    /**
     * 
     * @return InjectorInterface
     */
    function build(): InjectorInterface;

}
