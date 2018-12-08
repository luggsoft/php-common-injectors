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
     * @return int
     */
    function getIndex(): int;

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

    /**
     * 
     * @param ArgumentInterface $argument
     * @param mixed $value
     * @return bool
     */
    function tryResolveArgument(ArgumentInterface $argument, &$value = null): bool;

}
