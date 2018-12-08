<?php

namespace CrystalCode\Php\Common\Injectors;

use PHPUnit\Framework\TestCase;
use stdClass;

class InjectorTest extends TestCase
{

    /**
     * 
     * @return void
     */
    public function testInjector1(): void
    {
        $injector = new Injector();

        $this->assertCount(0, $injector->getDefinitions());

        $this->assertInstanceOf(stdClass::class, $injector->create(stdClass::class));
    }

    /**
     * 
     * @return void
     */
    public function testInjector2(): void
    {
        $injector = new Injector([
            new Definition(stdClass::class),
        ]);

        $this->assertCount(1, $injector->getDefinitions());

        $this->assertInstanceOf(stdClass::class, $injector->create(stdClass::class));
    }

    /**
     * 
     * @return void
     */
    public function testInjector3(): void
    {
        $object = new stdClass();

        $injector = new Injector([
            new CallableDefinition(stdClass::class, function () use ($object) {
                  return $object;
              }),
        ]);

        $this->assertCount(1, $injector->getDefinitions());

        $this->assertInstanceOf(stdClass::class, $injector->create(stdClass::class));

        $this->assertSame($object, $injector->create(stdClass::class));
    }

    /**
     * 
     * @return void
     */
    public function testInjector4(): void
    {
        $injector = new Injector();

        $this->assertInstanceOf(ATest::class, $injector->create(ATest::class));

        $this->assertNotSame($injector->create(ATest::class), $injector->create(stdClass::class));
    }

    /**
     * 
     * @return void
     */
    public function testInjector5(): void
    {
        $injector = new Injector();

        $this->assertInstanceOf(BTest::class, $injector->create(BTest::class));

        $this->assertInstanceOf(ATest::class, $injector->create(BTest::class)->getATest());
    }

    /**
     * 
     * @return void
     */
    public function testInjector6(): void
    {
        $injector = new Injector([
            new CallableDefinition(ATest::class, function () {
                  return new ATest(['name' => 'foo']);
              }),
            new Definition(BTest::class, [], [
                new CallableDefinition(ATest::class, function () {
                      return new ATest(['name' => 'bar']);
                  }),
              ]),
        ]);

        $this->assertEquals('foo', $injector->create(ATest::class)->getValue('name'));

        $this->assertEquals('bar', $injector->create(BTest::class)->getATest()->getValue('name'));
    }

}
