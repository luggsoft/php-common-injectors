<?php

namespace CrystalCode\Php\Common\Injectors;

use Closure;
use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\OperationException;
use CrystalCode\Php\Common\ParameterException;
use ReflectionFunction as FunctionCallableReflection;
use ReflectionFunctionAbstract as CallableReflectionBase;
use ReflectionMethod as MethodCallableReflection;

class InjectorBase implements InjectorInterface
{

    /**
     * 
     * @param callable $callable
     * @param array $values
     * @return mixed
     */
    final public static function callByName(callable $callable, array $values = [])
    {
        $callableReflection = self::getCallableReflection($callable);
        $arguments = [];
        foreach ($callableReflection->getParameters() as $parameterReflection) {
            $parameter = new Parameter($parameterReflection);
            $arguments[] = self::getParameterValue($values, $parameter);
        }
        return call_user_func_array($callable, $arguments);
    }

    /**
     * 
     * @param array $values
     * @param ParameterInterface $parameter
     * @return array
     * @throws OperationException
     */
    private static function getParameterValue(array $values, ParameterInterface $parameter)
    {
        $name = $parameter->getName();
        if (array_key_exists($name, $values)) {
            return $values[$name];
        }
        if ($parameter->hasDefaultValue()) {
            return $parameter->getDefaultValue();
        }
        throw new OperationException();
    }

    /**
     *
     * @param callable $callable
     * @return CallableReflectionBase
     * @throws ParameterException
     */
    private static function getCallableReflection(callable $callable): CallableReflectionBase
    {
        if (is_string($callable)) {
            return new FunctionCallableReflection($callable);
        }
        if (is_object($callable) && $callable instanceof Closure) {
            return new FunctionCallableReflection($callable);
        }
        if (is_array($callable) && isset($callable[0], $callable[1])) {
            return new MethodCallableReflection($callable[0], $callable[1]);
        }
        throw new ParameterException('callable');
    }

    /**
     *
     * @var array|DefinitionInterface[]
     */
    private $definitions = [];

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(iterable $definitions = [])
    {
        $this->addDefinitions($definitions);
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function getDefinition(string $className, array $values = [], iterable $definitions = []): DefinitionInterface
    {
        if (isset($this->definitions[$className])) {
            return $this->definitions[$className]->withValues($values)->withDefinitions($definitions);
        }
        return new Definition($className, $values, $definitions);
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function hasDefinition(string $className): bool
    {
        return isset($this->definitions[$className]);
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinition(DefinitionInterface $definition): InjectorInterface
    {
        $clone = clone $this;
        $clone->addDefinition($definition);
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(iterable $definitions): InjectorInterface
    {
        $clone = clone $this;
        $clone->addDefinitions($definitions);
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function create(string $className, array $values = [], iterable $definitions = [])
    {
        $definition = $this->getDefinition($className, $values, $definitions);
        return $definition->resolve($this);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function call(callable $callable, array $values = [], iterable $definitions = [])
    {
        $arguments = [];
        foreach (static::getCallableReflection($callable)->getParameters() as $parameterReflection) {
            $parameter = new Parameter($parameterReflection);
            $arguments[] = $this->resolveParameter($parameter, $values, $definitions);
        }
        return call_user_func_array($callable, $arguments);
    }

    /**
     *
     * @param ParameterInterface $parameter
     * @param array $values
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     * @throws InjectorException
     */
    private function resolveParameter(ParameterInterface $parameter, array $values, iterable $definitions)
    {
        $name = $parameter->getName();
        if (isset($values[$name])) {
            return $values[$name];
        }
        if ($parameter->hasClassName()) {
            $className = $parameter->getClassName();
            return $this->withDefinitions($definitions)->create($className);
        }
        if ($parameter->hasDefaultValue()) {
            return $parameter->getDefaultValue();
        }
        throw new InjectorException(InjectorException::getParameterInjectionFailedMessage($name), null);
    }

    /**
     *
     * @param DefinitionInterface $definition
     * @return void
     */
    final protected function addDefinition(DefinitionInterface $definition): void
    {
        $this->definitions[$definition->getClassName()] = $definition;
    }

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    final protected function addDefinitions($definitions): void
    {
        foreach (Collection::create($definitions) as $definition) {
            $this->addDefinition($definition);
        }
    }

}
