<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class Operator
{
    /**
     * Needs to be set by each operator class
     */
    const NAME = 'INVALID_OPERATOR';

    // Not sure about this:
    // /** @var string Nice name */
    // protected $label;

    /**
     * The number of elements this operator demands from the stack. If null,
     * one more element is fetched to determine the number of required elements
     * for operators allowing for a variable amount of elements
     *
     * TODO: This is our arity. We have operators dealing with Sets and we have
     *       stack operators, both are a little bit... special. This needs improvement
     */
    protected ?int $parameterCount = 0;

    protected bool $isVariadic = false;

    /**
     * This property is necessary, as there is some inconsistency when it goes
     * to reading the variadic parameter count (n). Examples:
     *
     *   <val n>,...,<val 1>,<percent>,n,PERCENT
     *   <val n>,...,<val 1>,n,<window>,x,PREDICT
     *
     * First=true means that the variadic parameter count is the first fixed
     * parameter when reading in RPN order (from right to left), false means
     * that it is the last one
     */
    protected bool $variadicCountIsFirst = false;

    public function getParameterCount(): ?int
    {
        return $this->parameterCount;
    }

    public function isVariadic(): bool
    {
        return $this->isVariadic;
    }

    public function variadicCountIsFirst(): bool
    {
        return $this->variadicCountIsFirst;
    }
}
