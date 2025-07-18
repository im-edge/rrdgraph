<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Data;

/**
 * Create a new in-memory set of (transformed) data points
 *
 * man rrdgraph_data
 * -----------------
 *
 * This command creates a new set of data points (in memory only, not in the
 * RRD file) out of one or more other data series. The RPN instructions are
 * used to evaluate a mathematical function on each data point. The resulting
 * vname can then be used further on in the script, just as if it were
 * generated by a DEF instruction.
 *
 * Example: CDEF:mydatabits=mydata,8,*
 *
 * Synopsis
 * --------
 * CDEF:vname=RPN expression
 */
class DataCalculation extends Expression
{
    public const TAG = 'CDEF';
}
