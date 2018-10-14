<?php

namespace CrystalCode\Php\Common\Injectors;

interface ParameterInterface
{

    /**
     *
     * @return string
     */
    function getName(): string;

    /**
     *
     * @return string
     */
    function getClassName(): string;

    /**
     *
     * @return bool
     */
    function hasClassName(): bool;

    /**
     *
     * @return mixed
     */
    function getDefaultValue();

    /**
     *
     * @return bool
     */
    function hasDefaultValue(): bool;

}
