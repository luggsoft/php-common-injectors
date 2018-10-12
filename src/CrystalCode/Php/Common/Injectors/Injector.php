<?php

namespace CrystalCode\Php\Common\Injectors;

final class Injector extends InjectorBase
{

    /**
     * 
     * @param iterable|DefinitionInterface[] $definitions
     * @return ScopedInjector
     */
    public function createScopedInjector($definitions = []): ScopedInjector
    {
        return new ScopedInjector($this, $definitions);
    }

}
