<?php

namespace Tests\Snagshout\Nucleus\Data;

use Snagshout\Nucleus\Data\ArrayList;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class ArrayListTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Data
 */
class ArrayListTest extends TestCase
{
    public function testConstructor()
    {
        $this->expectNotToPerformAssertions();

        new ArrayList();
        new ArrayList([]);
        new ArrayList(['hello', 'world']);
    }

    public function testZero()
    {
        $instance = ArrayList::zero();

        $this->assertEquals([], $instance->toArray());
    }

    public function testAppend()
    {
        $instance = ArrayList::of(['hello']);

        $final = $instance->append(ArrayList::of(['world']));

        $this->assertNotEquals($instance, $final);
        $this->assertEquals(['hello', 'world'], $final->toArray());
    }

    public function testOf()
    {
        $list = ArrayList::of(['hello', 'world']);

        $this->assertInstanceOf(ArrayList::class, $list);
    }
}
