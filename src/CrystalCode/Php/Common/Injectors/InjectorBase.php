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
    private static function getCallableReflection(callable $callable)
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
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct($definitions = [])
    {
        $this->addDefinitions($definitions);
    }

    /**
     *
     * @param string $className
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return DefinitionInterface
     */
    final public function getDefinition($className, array $values = [], $definitions = [])
    {
        if (isset($this->definitions[$className])) {
            return $this->definitions[$className]->withValues($values)->withDefinitions($definitions);
        }
        return new Definition($className, $values, $definitions);
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
     * @param DefinitionInterface $definition
     * @return InjectorInterface
     */
    final public function withDefinition(DefinitionInterface $definition)
    {
        $clone = clone $this;
        $clone->addDefinition($definition);
        return $clone;
    }

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return InjectorInterface
     */
    final public function withDefinitions($definitions)
    {
        $clone = clone $this;
        $clone->addDefinitions($definitions);
        return $clone;
    }

    /**
     *
     * @param string $className
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return mixed
     */
    public function create($className, array $values = [], $definitions = [])
    {
        $definition = $this->getDefinition($className, $values, $definitions);
        return $definition->resolve($this);
    }

    /**
     *
     * @param callable $callable
     * @param array $values
     * @param DefinitionInterface[] $definitions
     * @return mixed
     */
    public function call(callable $callable, array $values = [], $definitions = [])
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
     * @param DefinitionInterface[] $definitions
     * @return mixed
     * @throws InjectorException
     */
    private function resolveParameter(ParameterInterface $parameter, array $values, $definitions)
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
    final protected function addDefinition(DefinitionInterface $definition)
    {
        $this->definitions[$definition->getClassName()] = $definition;
    }

    /**
     *
     * @param DefinitionInterface[] $definitions
     * @return void
     */
    final protected function addDefinitions($definitions)
    {
        foreach (Collection::create($definitions) as $definition) {
            $this->addDefinition($definition);
        }
    }

}
