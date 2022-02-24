<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Color;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\StringType;
use gipfl\RrdGraph\ParseUtils;

abstract class DefinitionBasedGraphInstruction implements GraphInstructionInterface
{
    protected VariableName $definition;
    protected Color $color;
    protected ?StringType $legend = null;

    public function __construct(VariableName $definition, ?Color $color = null, ?StringType $legend = null)
    {
        $this->definition = $definition;
        $this->color = $color;
        $this->legend = $legend;
    }

    public static function parse(string $string): GraphInstructionInterface
    {
        return static::fromParameterString(ParseUtils::stripRequiredTag($string, static::TAG));
    }
}
