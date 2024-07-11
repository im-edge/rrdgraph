<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * These operators work only on VDEF statements. Note that currently ONLY these
 * work for VDEF.
 */
abstract class VariablesOperator extends Operator
{
    protected ?int $parameterCount = 1;
}
