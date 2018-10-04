<?php

namespace CrystalCode\Php\Common\Injectors;

interface ParameterInterface
{

    /**
     *
     * @return string
     */
    function getName();

    /**
     *
     * @return string
     */
    function getClassName();

    /**
     *
     * @return bool
     */
    function hasClassName();

    /**
     *
     * @return mixed
     */
    function getDefaultValue();

    /**
     *
     * @return bool
     */
    function hasDefaultValue();

}
