<?php

namespace CrystalCode\Php\Common\Injectors;

use ArrayIterator;
use CrystalCode\Php\Common\ArgumentException;
use IteratorAggregate;
use Traversable;

final class ArgumentSet implements IteratorAggregate
{

    /**
     * 
     * @param iterable $values
     * @return ArgumentSet
     */
    public static function createFromValues(iterable $values): ArgumentSet
    {
        $arguments = [];

        foreach ($values as $key => $value) {
            $arguments[] = self::createArgumentFromKeyAndValue($key, $value);
        }

        return new ArgumentSet(...$arguments);
    }

    /**
     * 
     * @param mixed $key
     * @param mixed $value
     * @return ArgumentInterface
     * @throws ArgumentException
     */
    public static function createArgumentFromKeyAndValue($key, $value): ArgumentInterface
    {
        if (is_int($key)) {
            return new IndexedArgument($key, $value);
        }

        if (is_string($key)) {
            return new NamedArgument($key, $value);
        }

        throw new ArgumentException('key');
    }

    /**
     *
     * @var array|ArgumentInterface[]
     */
    private $arguments = [];

    /**
     * 
     * @param iterable|ArgumentInterface[] $arguments
     */
    public function __construct(ArgumentInterface ...$arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->arguments);
    }

    /**
     * 
     * @param ParameterInterface $parameter
     * @param type $value
     * @return bool
     */
    public function tryResolveParameter(ParameterInterface $parameter, &$value = null): bool
    {
        foreach ($this->arguments as $argument) {
            if ($argument->tryResolveParameter($parameter, $argument, $value)) {
                return true;
            }
        }

        $value = null;
        return false;
    }

}
