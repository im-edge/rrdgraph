<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Color;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\StringType;

abstract class DefinitionBasedGraphInstruction implements GraphInstructionInterface
{
    const TAG = 'DEFINITION_WITHOUT_TAG';
    protected VariableName $definition;
    protected ?Color $color = null;
    protected ?StringType $legend = null;

    final public function __construct(VariableName $definition, ?Color $color = null, ?StringType $legend = null)
    {
        $this->definition = $definition;
        $this->color = $color;
        $this->legend = $legend;
    }

    public static function fromParameters(array $parameters)
    {
        $variable = array_shift($parameters);
        $parts = explode('#', $variable);
        $varName = new VariableName(array_shift($parts));
        foreach ($parameters as &$parameter) {
            if (is_string($parameter)) {
                $parameter = new StringType($parameter);
            }
        }
        if (empty($parts)) {
            array_unshift($parameters, null);
        } else {
            foreach (array_reverse($parts) as $color) {
                array_unshift($parameters, new Color($color));
            }
        }
        array_unshift($parameters, $varName);
        return new static(...$parameters);
    }
}
