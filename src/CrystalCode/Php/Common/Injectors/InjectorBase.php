<?php

namespace CrystalCode\Php\Common\Injectors;

use Closure;
use CrystalCode\Php\Common\ParameterException;
use ReflectionFunction as FunctionCallableReflection;
use ReflectionFunctionAbstract as CallableReflectionBase;

class InjectorBase implements InjectorInterface
{

    /**
     *
     * @param callable $callable
     * @return CallableReflectionBase
     * @throws ParameterException
     */
    private static function getCallableReflection(callable $callable): CallableReflectionBase
    {
        $closure = Closure::fromCallable($callable);

        return new FunctionCallableReflection($closure);
    }

    /**
     *
     * @var array|DefinitionInterface[]
     */
    private $definitions = [];

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     */
    public function __construct(iterable $definitions = [])
    {
        $this->addDefinitions(...$definitions);
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function getDefinition(string $className, iterable $arguments = [], iterable $definitions = []): DefinitionInterface
    {
        foreach ($this->definitions as $definition) {
            if ($definition->getClassName() === $className) {
                return $definition->withArguments(...$arguments)->withDefinitions(...$definitions);
            }
        }

        return new Definition($className, $arguments, $definitions);
    }

    /**
     * 
     * @return iterable|DefinitionInterface[]
     */
    final public function getDefinitions(): iterable
    {
        return $this->definitions;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function hasDefinition(string $className): bool
    {
        foreach ($this->definitions as $definition) {
            if ($definition->getClassName() === $className) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(DefinitionInterface ...$definitions): InjectorInterface
    {
        $clone = clone $this;
        $clone->addDefinitions(...$definitions);
        return $clone;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function create(string $className, iterable $arguments = [], iterable $definitions = [])
    {
        $definition = $this->getDefinition($className, $arguments, $definitions);
        return $definition->resolve($this);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function call(callable $callable, iterable $arguments = [], iterable $definitions = [])
    {
        $values = [];

        foreach (static::getCallableReflection($callable)->getParameters() as $parameterReflection) {
            $parameter = new Parameter($parameterReflection);
            $values[] = $this->resolveParameter($parameter, $arguments, $definitions);
        }

        return call_user_func_array($callable, $values);
    }

    /**
     *
     * @param ParameterInterface $parameter
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return mixed
     * @throws InjectorException
     */
    private function resolveParameter(ParameterInterface $parameter, iterable $arguments, iterable $definitions)
    {
        $value = null;

        if ($this->tryResolveParameterFromArguments($parameter, $arguments, $value)) {
            return $value;
        }

        if ($parameter->hasClassName()) {
            $className = $parameter->getClassName();
            return $this->withDefinitions($definitions)->create($className);
        }

        if ($parameter->hasDefaultValue()) {
            return $parameter->getDefaultValue();
        }

        $name = $parameter->getName();
        $message = InjectorException::getParameterInjectionFailedMessage($name);
        throw new InjectorException($message, null);
    }

    /**
     * 
     * @param ParameterInterface $parameter
     * @param iterable|ArgumentInterface[] $arguments
     * @param mixed $value
     * @return bool
     */
    private function tryResolveParameterFromArguments(ParameterInterface $parameter, iterable $arguments, &$value): bool
    {
        $name = $parameter->getName();

        foreach ($arguments as $argument) {
            if ($argument instanceof NamedArgument) {
                if ($argument->getName() === $name) {
                    $value = $argument->getValue();
                    return true;
                }
            }
        }

        $index = $parameter->getIndex();

        foreach ($arguments as $argument) {
            if ($argument instanceof IndexedArgument) {
                if ($argument->getIndex() === $index) {
                    $value = $argument->getValue();
                    return true;
                }
            }
        }

        return false;
    }

    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    final protected function addDefinitions(DefinitionInterface ...$definitions): void
    {
        foreach ($definitions as $definition) {
            $this->definitions[] = $definition;
        }
    }

}
