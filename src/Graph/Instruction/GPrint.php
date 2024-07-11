<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

/**
 * man rrdgraph_graph
 * ------------------
 * This is the same as PRINT, but printed inside the graph.
 *
 * Synopsis
 * --------
 * GPRINT:vname:format
 *
 * TODO: Check whether [:strftime|:valstrftime|:valstrfduration] is allowed,
 *       documentation doesn't mention them
 */
class GPrint extends PrintGraphInstruction
{
    const TAG = 'GPRINT';
}
