<?php

namespace CrystalCode\Php\Common\Injectors;

use PHPUnit\Framework\TestCase;
use ReflectionFunction as FunctionReflection;
use ReflectionParameter as ParameterReflection;

class ParameterTest extends TestCase
{

    public function testParameter1(): void
    {
        namedArgument: {
            $namedArgument = new NamedArgument('a', 42);
            $value = null;
            $isResolved = $this->getParameterA()->tryResolveArgument($namedArgument, $value);
            $this->assertTrue($isResolved);
            $this->assertEquals($value, 42);
        }

        indexedArgument: {
            $indexedArgument = new IndexedArgument(0, 42);
            $value = null;
            $isResolved = $this->getParameterA()->tryResolveArgument($indexedArgument, $value);
            $this->assertTrue($isResolved);
            $this->assertEquals($value, 42);
        }
    }

    public function testParameter2(): void
    {
        namedArgument: {
            $namedArgument = new NamedArgument('a', 42);
            $value = null;
            $isResolved = $this->getParameterAOfInt()->tryResolveArgument($namedArgument, $value);
            $this->assertTrue($isResolved);
            $this->assertEquals($value, 42);
        }

        indexedArgument: {
            $indexedArgument = new IndexedArgument(0, 42);
            $value = null;
            $isResolved = $this->getParameterAOfInt()->tryResolveArgument($indexedArgument, $value);
            $this->assertTrue($isResolved);
            $this->assertEquals($value, 42);
        }
    }

    private function getParameterA(): ParameterInterface
    {
        $functionReflection = new FunctionReflection(function ($a) {
            // @noop
        });
        $parameterReflection = $functionReflection->getParameters()[0];
        return new Parameter($parameterReflection);
    }

    private function getParameterAOfInt(): ParameterInterface
    {
        $functionReflection = new FunctionReflection(function (int $a) {
            // @noop
        });
        $parameterReflection = $functionReflection->getParameters()[0];
        return new Parameter($parameterReflection);
    }

    private function getParameterAWithNullDefault(): ParameterInterface
    {
        $functionReflection = new FunctionReflection(function ($a = null) {
            // @noop
        });
        $parameterReflection = $functionReflection->getParameters()[0];
        return new Parameter($parameterReflection);
    }

    private function getParameterAOfIntWith42Default(): ParameterInterface
    {
        $functionReflection = new FunctionReflection(function (int $a = 42) {
            // @noop
        });
        $parameterReflection = $functionReflection->getParameters()[0];
        return new Parameter($parameterReflection);
    }

    private function getParameterAOfIntWithNullDefault(): ParameterInterface
    {
        $functionReflection = new FunctionReflection(function (int $a = null) {
            // @noop
        });
        $parameterReflection = $functionReflection->getParameters()[0];
        return new Parameter($parameterReflection);
    }

}
