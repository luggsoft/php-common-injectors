<?php

namespace CrystalCode\Php\Common\Injectors;

final class Injector extends InjectorBase
{

    /**
     * 
     * @param DefinitionInterface[] $definitions
     * @return ScopedInjector
     */
    public function createScopedInjector($definitions = [])
    {
        return new ScopedInjector($this, $definitions);
    }

}
