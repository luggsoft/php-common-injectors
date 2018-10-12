<?php

namespace CrystalCode\Php\Common\Injectors;

use \CrystalCode\Php\Common\Collections\Collection;
use \CrystalCode\Php\Common\ParameterException;
use \Exception;
use \ReflectionClass as ClassReflection;

abstract class DefinitionBase implements DefinitionInterface
{

    /**
     *
     * @var ClassReflection
     */
    private $classReflection;

    /**
     *
     * @var array
     */
    private $values = [];

    /**
     *
     * @var array|DefinitionInterface[]
     */
    private $definitions = [];

    /**
     *
     * @param ClassReflection $classReflection
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(ClassReflection $classReflection, array $values = [], iterable $definitions = [])
    {
        $this->classReflection = $classReflection;
        foreach ($values as $name => $value) {
            $this->values[(string) $name] = $value;
        }
        $this->addDefinitions($definitions);
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function getClassName(): string
    {
        return $this->classReflection->getName();
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    final public function getValue(string $name)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }
        return null;
    }

    /**
     *
     * @param string $name
     * @return bool
     */
    final public function hasValue(string $name): bool
    {
        return isset($this->values[$name]);
    }

    /**
     *
     * @return array
     */
    final public function getValues(): array
    {
        return $this->values;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withValue(string $name, $value): DefinitionInterface
    {
        $clone = clone $this;
        $clone->values[(string) $name] = $value;
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withValues(array $values): DefinitionInterface
    {
        $copy = clone $this;
        foreach ($values as $name => $value) {
            $copy->values[(string) $name] = $value;
        }
        return $copy;
    }

    /**
     *
     * @param string $className
     * @return DefinitionInterface
     * @throws ParameterException
     */
    final public function getDefinition(string $className): DefinitionInterface
    {
        if (isset($this->definitions[$className])) {
            return $this->definitions[$className];
        }
        throw new ParameterException('className');
    }

    /**
     *
     * @param string $className
     * @return bool
     */
    final public function hasDefinition(string $className): bool
    {
        return isset($this->definitions[$className]);
    }

    /**
     *
     * @return array|DefinitionInterface[]
     */
    final public function getDefinitions(): iterable
    {
        return array_values($this->definitions);
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinition(DefinitionInterface $definition): DefinitionInterface
    {
        $clone = clone $this;
        $clone->addDefinition($definition);
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(iterable $definitions): DefinitionInterface
    {
        $clone = clone $this;
        $clone->addDefinitions($definitions);
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     * 
     * @throws InjectorException
     */
    final public function resolve(InjectorInterface $injector): object
    {
        try {
            return $this->getInstance($injector);
        }
        catch (Exception $exception) {
            $className = $this->getClassName();
            throw new InjectorException(InjectorException::getDefinitionInjectionFailedMessage($className), null, $exception);
        }
    }

    /**
     *
     * @return ClassReflection
     */
    final protected function getClassReflection(): ClassReflection
    {
        return $this->classReflection;
    }

    /**
     *
     * @param DefinitionInterface $definition
     * @return void
     */
    private function addDefinition(DefinitionInterface $definition): void
    {
        $this->definitions[$definition->getClassName()] = $definition;
    }

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    private function addDefinitions(iterable $definitions): void
    {
        foreach (Collection::create($definitions) as $definition) {
            $this->addDefinition($definition);
        }
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    abstract protected function getInstance(InjectorInterface $injector): object;
}
