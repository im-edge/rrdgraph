<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Data;

use IMEdge\RrdGraph\Rpn\RpnExpression;

/**
 * Either a CDEF or a VDEF
 *
 * About CDEF versus VDEF (man rrdgraph_data)
 * ------------------------------------------
 * At some point in processing, RRDtool has gathered an array of rates ready to
 * display.
 *
 * CDEF works on such an array. For example, CDEF:new=ds0,8,* would multiply
 * each of the array members by eight (probably transforming bytes into bits).
 * The result is an array containing the new values.
 *
 * VDEF also works on such an array but in a different way. For example,
 * VDEF:max=ds0,MAXIMUM would scan each of the array members and store the
 * maximum value.
 *
 * When do you use VDEF versus CDEF?
 * ---------------------------------
 *
 * Use CDEF to transform your data prior to graphing. In the above example, we'd
 * use a CDEF to transform bytes to bits before graphing the bits.
 *
 * You use a VDEF if you want max(1,5,3,2,4) to return five which would be
 * displayed in the graph's legend (to answer, what was the maximum value during
 * the graph period).
 *
 * If you want to apply 'complex' operations to the result of a VDEF you have
 * to use a CDEF again since VDEFs only look like RPN expressions, they aren't
 * really.
 */
abstract class Expression extends RpnExpression implements DataDefinitionInterface
{
    public const TAG = 'INVALID';
}
