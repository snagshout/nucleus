<?php

namespace Tests\Snagshout\Nucleus\Meditation;

use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\TypedSpec;
use Snagshout\Nucleus\Testing\TestCase;
use Snagshout\Nucleus\Validation\Constraints\StringLengthConstraint;

/**
 * Class TypedSpecTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Meditation
 */
class TypedSpecTest extends TestCase
{
    public function testCheck()
    {
        $spec = TypedSpec::define()
            ->withFieldType('first_name', Boa::string())
            ->withFieldType('age', Boa::integer());

        $this->assertTrue($spec->check([
            'first_name' => 'Ed',
            'age' => 23
        ])->passed());
    }

    public function testCheckWithFailures()
    {
        $spec = TypedSpec::define()
            ->withFieldType('first_name', Boa::string())
            ->withFieldType('age', Boa::integer());

        $result = $spec->check([
            'first_name' => 'Ed',
            'age' => 34.7
        ]);

        $this->assertTrue($result->failed());
        $this->assertEquals(['age'], array_keys($result->getFailed()));
    }

    public function testCheckWithConstraints()
    {
        $spec = TypedSpec::define()
            ->withFieldType('first_name', Boa::string())
            ->withFieldConstraints('first_name', new StringLengthConstraint(4))
            ->withFieldType('age', Boa::integer());

        $this->assertTrue($spec->check([
            'first_name' => 'Eduardo',
            'age' => 23
        ])->passed());
    }

    public function testCheckWithFailedConstraints()
    {
        $spec = TypedSpec::define()
            ->withFieldType('first_name', Boa::string())
            ->withFieldConstraints('first_name', new StringLengthConstraint(4))
            ->withFieldType('age', Boa::integer());

        $result = $spec->check([
            'first_name' => 'Ed',
            'age' => 23
        ]);

        $this->assertTrue($result->failed());
        $this->assertEquals(['first_name'], array_keys($result->getFailed()));
    }
}
