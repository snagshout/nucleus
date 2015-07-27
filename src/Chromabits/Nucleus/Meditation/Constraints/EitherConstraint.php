<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class EitherConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class EitherConstraint extends AbstractConstraint
{
    /**
     * First type.
     *
     * @var AbstractConstraint
     */
    protected $one;

    /**
     * Second type.
     *
     * @var AbstractConstraint
     */
    protected $other;

    /**
     * Construct an instance of an EitherConstraint.
     *
     * @param AbstractConstraint $one
     * @param AbstractConstraint $other
     */
    public function __construct(
        AbstractConstraint $one,
        AbstractConstraint $other
    ) {
        $this->one = $one;
        $this->other = $other;
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function check($value)
    {
        return truthy(
            $this->one->check($value),
            $this->other->check($value)
        );
    }

    /**
     * Return whether the constraint is defined by an union of types.
     *
     * @return bool
     */
    public function isUnion()
    {
        return true;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        $one = $this->one->toString();
        $other = $this->other->toString();

        $one = $this->one->isUnion() ? sprintf('(%s)', $one) : $one;
        $other = $this->other->isUnion() ? sprintf('(%s)', $other) : $other;

        return sprintf('%s|%s', $one, $other);
    }
}
