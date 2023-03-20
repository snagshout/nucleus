<?php

namespace Tests\Snagshout\Nucleus\Foundation;

use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Foundation\Entity;
use Snagshout\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class EntityTest
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Foundation
 */
class EntityTest extends TestCase
{
    public function testFill()
    {
        $instance = new SampleEntity();

        $instance->setFirstName('Bobby');

        $instance->fill([
            'last_name' => 'tables',
            'age' => '34',
            'pin' => 1337
        ]);

        $this->assertEquals([
            'first_name' => 'Bobby',
            'last_name' => 'Tables',
            'age' => 34,
        ], $instance->toArray());
    }

    public function testFillWithUndeclared()
    {
        $this->expectException(LackOfCoffeeException::class);

        $instance = Mockery::mock(Entity::class)
            ->makePartial();

        /** @var Entity $instance */
        $instance->fill([]);
    }
}
