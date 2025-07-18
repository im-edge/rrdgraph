<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\DataType\StringType;

/**
 * Comment text to be printed to the legend
 *
 * man rrdgraph_graph
 * ------------------
 *
 * Text is printed literally in the legend section of the graph. Note that in
 * RRDtool 1.2 you have to escape colons in COMMENT text in the same way you
 * have to escape them in *PRINT commands by writing '\:'.
 *
 * Synopsis
 * --------
 *
 * COMMENT:text
 */
class Comment implements GraphInstructionInterface
{
    public const TAG = 'COMMENT';

    public StringType $text;

    public function __construct(StringType $text)
    {
        $this->text = $text;
    }

    public function __toString(): string
    {
        return self::TAG . ':' . $this->text;
    }

    public static function fromParameters(array $parameters): Comment
    {
        $parameters[0] = StringType::parse($parameters[0]);

        return new Comment($parameters[0]);
    }
}
