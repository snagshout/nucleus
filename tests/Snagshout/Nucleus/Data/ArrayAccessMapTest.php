<?php

namespace Tests\Snagshout\Nucleus\Data;

use ArrayObject;
use Snagshout\Nucleus\Control\Maybe;
use Snagshout\Nucleus\Data\ArrayAccessMap;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class ArrayAccessMapTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Data
 */
class ArrayAccessMapTest extends TestCase
{
    public function testConstructor()
    {
        $this->expectNotToPerformAssertions();
        new ArrayAccessMap(new ArrayObject(['great' => 'job']));
    }

    public function testLookup()
    {
        $instance = new ArrayAccessMap(new ArrayObject(['great' => 'job']));

        $this->assertTrue($instance->lookup('omg')->isNothing());
        $this->assertTrue($instance->lookup('great')->isJust());
        $this->assertEquals('job', Maybe::fromJust($instance->lookup('great')));
    }

    public function testInsert()
    {
        $instance = new ArrayAccessMap(new ArrayObject(['great' => 'job']));

        $instance2 = $instance->insert('omg', 'wow');

        $this->assertNotSame($instance, $instance2);
        $this->assertEquals('wow', Maybe::fromJust($instance2->lookup('omg')));
    }

    public function testDelete()
    {
        $instance = new ArrayAccessMap(new ArrayObject(['great' => 'job']));

        $instance2 = $instance->delete('great');

        $this->assertNotSame($instance, $instance2);
        $this->assertTrue($instance2->lookup('great')->isNothing());
    }

    public function testMember()
    {
        $instance = new ArrayAccessMap(new ArrayObject(['great' => 'job']));

        $this->assertTrue($instance->member('great'));
        $this->assertFalse($instance->member('wow'));
    }
}
