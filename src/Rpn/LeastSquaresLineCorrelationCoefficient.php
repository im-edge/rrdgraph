<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Return the parameters for a Least Squares Line (y = mx +b) which approximate
 * the provided dataset.
 *
 * LSLCORREL is the Correlation Coefficient (also know as Pearson's Product
 * Moment Correlation Coefficient). It will range from 0 to +/-1 and represents
 * the quality of fit for the approximation.
 */
class LeastSquaresLineCorrelationCoefficient extends VariablesOperator
{
    public const NAME = 'LSLCORREL';
}
