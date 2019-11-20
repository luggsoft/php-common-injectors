<?php

namespace Luggsoft\Php\Common\Injectors;

use Exception;
use Luggsoft\Php\Common\ArgumentException;
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
    private $arguments = [];
    
    /**
     *
     * @var array|DefinitionInterface[]
     */
    private $definitions = [];
    
    /**
     *
     * @param ClassReflection $classReflection
     * @param iterable|ArgumentInterface[] $arguments
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    public function __construct(ClassReflection $classReflection, iterable $arguments = [], iterable $definitions = [])
    {
        $this->classReflection = $classReflection;
        $this->addArguments(...$arguments);
        $this->addDefinitions(...$definitions);
    }
    
    /**
     *
     * @param iterable|ArgumentInterface[] $arguments
     * @return void
     */
    private function addArguments(ArgumentInterface ...$arguments): void
    {
        foreach ($arguments as $argument) {
            $this->arguments[] = $argument;
        }
    }
    
    /**
     *
     * @param iterable|DefinitionInterface[] $definitions
     * @return void
     */
    private function addDefinitions(DefinitionInterface ...$definitions): void
    {
        foreach ($definitions as $definition) {
            $this->definitions[] = $definition;
        }
    }
    
    /**
     *
     * {@inheritdoc}
     */
    final public function getArguments(): iterable
    {
        return $this->arguments;
    }
    
    /**
     *
     * @param string $name
     * @return bool
     */
    final public function hasNamedArgument(string $name): bool
    {
        foreach ($this->getNamedArguments() as $namedArgument) {
            if ($namedArgument->getName() === $name) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     *
     * @return iterable|NamedArgument[]
     */
    final public function getNamedArguments(): iterable
    {
        foreach ($this->arguments as $argument) {
            if ($argument instanceof IndexedArgument) {
                yield $argument;
            }
        }
    }
    
    /**
     *
     * @param int $index
     * @return bool
     */
    final public function hasIndexedArgument(int $index): bool
    {
        foreach ($this->getIndexedArguments() as $indexedArgument) {
            if ($indexedArgument->getIndex() === $index) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     *
     * @return iterable|IndexedArgument[]
     */
    final public function getIndexedArguments(): iterable
    {
        foreach ($this->arguments as $argument) {
            if ($argument instanceof IndexedArgument) {
                yield $argument;
            }
        }
    }
    
    /**
     *
     * @param string $name
     * @return NamedArgument
     * @throws ArgumentException
     */
    final public function getNamedArgument(string $name): NamedArgument
    {
        foreach ($this->getNamedArguments() as $namedArgument) {
            if ($namedArgument->getName() === $name) {
                return $namedArgument;
            }
        }
        
        throw new ArgumentException($name);
    }
    
    /**
     *
     * @param int $index
     * @return IndexedArgument
     * @throws Exception
     */
    final public function getIndexedArgument(int $index): IndexedArgument
    {
        foreach ($this->getIndexedArguments() as $indexedArgument) {
            if ($indexedArgument->getIndex() === $index) {
                return $indexedArgument;
            }
        }
        
        $message = vsprintf('No argument found at index %d', [
            $index,
        ]);
    }
    
    /**
     *
     * {@inheritdoc}
     */
    final public function getDefinitions(): iterable
    {
        return $this->definitions;
    }
    
    /**
     *
     * @param string $className
     * @return DefinitionInterface
     * @throws ArgumentException
     */
    final public function getDefinition(string $className): DefinitionInterface
    {
        foreach ($this->definitions as $definition) {
            if ($definition->getClassName() === $className) {
                return $definition;
            }
        }
        
        throw new ArgumentException('className');
    }
    
    /**
     *
     * @param string $className
     * @return bool
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
    final public function withArguments(ArgumentInterface ...$arguments): DefinitionInterface
    {
        $clone = clone $this;
        $clone->addArguments(...$arguments);
        return $clone;
    }
    
    /**
     *
     * {@inheritdoc}
     */
    final public function withDefinitions(DefinitionInterface ...$definitions): DefinitionInterface
    {
        $clone = clone $this;
        $clone->addDefinitions(...$definitions);
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
            $message = InjectorException::getDefinitionInjectionFailedMessage($className);
            throw new InjectorException($message, null, $exception);
        }
    }
    
    /**
     *
     * @param InjectorInterface $injector
     * @return object
     */
    abstract protected function getInstance(InjectorInterface $injector): object;
    
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
     * @return ClassReflection
     */
    final protected function getClassReflection(): ClassReflection
    {
        return $this->classReflection;
    }
    
}
