<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Remove the top element
 */
class RemoveTopStackElement extends StackOperator
{
    public const NAME = 'POP';
    protected ?int $parameterCount = 1;
    protected bool $isVariadic = false;
    protected ?RpnExpression $followUp = null;

    public function setFollowupExpression(RpnExpression $followUp): void
    {
        $this->followUp = $followUp;
    }

    public function getFollowUpExpression(): ?RpnExpression
    {
        return $this->followUp;
    }
}
