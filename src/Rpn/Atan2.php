<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Arctangent of y,x components (output in radians)
 *
 * This pops one element from the stack, the x (cosine) component, and then a
 * second, which is the y (sine) component. It then pushes the arctangent of
 * their ratio, resolving the ambiguity between quadrants.
 *
 * Example: CDEF:angle=Y,X,ATAN2,RAD2DEG will convert X,Y components into an
 *          angle in degrees.
 */
class Atan2 extends ArithmeticOperator
{
    public const NAME = 'ATAN2';

    protected ?int $parameterCount = 2;
}
