<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\DataType\AlignmentEnum;

/**
 * From `man rrdgraph_graph`:
 *
 * Labels are placed below the graph. When they overflow to the left, they wrap
 * to the next line. By default, lines are justified left and right.
 *
 * The TEXTALIGN function lets you change this default. This is a command and
 * not an option, so that you can change the default several times in your
 * argument list.
 */
class TextAlign implements GraphInstructionInterface
{
    const TAG = 'TEXTALIGN';

    protected AlignmentEnum $alignment;

    public function __construct(AlignmentEnum $alignment)
    {
        $this->alignment = $alignment;
    }

    public function __toString(): string
    {
        return self::TAG . ':' . $this->alignment;
    }

    public static function fromParameters(array $parameters): TextAlign
    {
        return new TextAlign(...$parameters);
    }
}
