<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Color;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\BooleanType;
use gipfl\RrdGraph\DataType\StringType;
use InvalidArgumentException;

abstract class DefinitionBasedGraphInstruction implements GraphInstructionInterface
{
    const TAG = 'DEFINITION_WITHOUT_TAG';
    protected VariableName $definition;
    protected ?Color $color = null;
    protected ?StringType $legend = null;

    const OPTIONAL_PARAMETERS = [];

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
        if (! empty($parts)) {
            $color = new Color(array_shift($parts));
        } else {
            $color = null;
        }
        foreach ($parameters as $key => $parameter) {
            if (isset(static::OPTIONAL_PARAMETERS[$parameter])) {
                $class = static::OPTIONAL_PARAMETERS[$parameter];
                $parameters[$key] = $class::parse($parameter);
            } else {
                $parameters[$key] = StringType::parse($parameter);
            }
        }
        if (! empty($parameters) && $parameters[0] instanceof StringType) {
            $legend = array_shift($parameters);
        } else {
            $legend = null;
        }

        $self =  new static($varName, $color, $legend);
        foreach ($parameters as $boolean) {
            if ($boolean instanceof BooleanType) {
                $self->{$boolean->getLabel()} = $boolean;
            } else {
                throw new InvalidArgumentException("Got unknown optional parameter: $boolean");
            }
        }

        return $self;
    }
}
