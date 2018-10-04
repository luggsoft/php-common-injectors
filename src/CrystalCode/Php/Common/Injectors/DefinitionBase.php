<?php

namespace CrystalCode\Php\Common\Injectors;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\ParameterException;
use Exception;
use ReflectionClass as ClassReflection;

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
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(ClassReflection $classReflection, array $values = [], $definitions = [])
    {
        $this->classReflection = $classReflection;
        foreach ($values as $name => $value) {
            $this->values[(string) $name] = $value;
        }
        $this->addDefinitions($definitions);
    }

    /**
     *
     * @return string
     */
    final public function getClassName()
    {
        return $this->classReflection->getName();
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    final public function getValue($name)
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
    final public function hasValue($name)
    {
        return isset($this->values[$name]);
    }

    /**
     *
     * @return array
     */
    final public function getValues()
    {
        return $this->values;
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return DefinitionInterface
     */
    final public function withValue($name, $value)
    {
        $copy = clone $this;
        $copy->values[(string) $name] = $value;
        return $copy;
    }

    /**
     *
     * @param array $values
     * @return DefinitionInterface
     */
    final public function withValues(array $values)
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
    final public function getDefinition($className)
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
    final public function hasDefinition($className)
    {
        return isset($this->definitions[$className]);
    }

    /**
     *
     * @return array|DefinitionInterface[]
     */
    final public function getDefinitions()
    {
        return array_values($this->definitions);
    }

    /**
     *
     * @param DefinitionInterface $definition
     * @return DefinitionInterface
     */
    final public function withDefinition(DefinitionInterface $definition)
    {
        $copy = clone $this;
        $copy->addDefinition($definition);
        return $copy;
    }

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    final public function withDefinitions($definitions)
    {
        $copy = clone $this;
        $copy->addDefinitions($definitions);
        return $copy;
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     * @throws InjectorException
     */
    final public function resolve(InjectorInterface $injector)
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
    final protected function getClassReflection()
    {
        return $this->classReflection;
    }

    /**
     *
     * @param DefinitionInterface $definition
     * @return void
     */
    private function addDefinition(DefinitionInterface $definition)
    {
        $this->definitions[$definition->getClassName()] = $definition;
    }

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    private function addDefinitions($definitions)
    {
        foreach (Collection::create($definitions) as $definition) {
            $this->addDefinition($definition);
        }
    }

    /**
     *
     * @param InjectorInterface $injector
     * @return mixed
     */
    abstract protected function getInstance(InjectorInterface $injector);
}
