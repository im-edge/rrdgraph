<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Color;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\BooleanType;
use gipfl\RrdGraph\DataType\StringType;
use InvalidArgumentException;
use RuntimeException;

abstract class DefinitionBasedGraphInstruction implements GraphInstructionInterface, InstructionWithVariableInterface
{
    const TAG = 'DEFINITION_WITHOUT_TAG';
    protected VariableName $definition;
    protected ?Color $color = null;
    protected ?StringType $legend = null;

    public const OPTIONAL_PARAMETERS = [];

    final public function __construct(VariableName $definition, ?Color $color = null, ?StringType $legend = null)
    {
        $this->definition = $definition;
        $this->color = $color;
        $this->legend = $legend;
    }

    public function getDefinition(): VariableName
    {
        return $this->definition;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): void
    {
        $this->color = $color;
    }

    public function getLegend(): ?StringType
    {
        return $this->legend;
    }

    public function setLegend(?StringType $legend): void
    {
        $this->legend = $legend;
    }

    public function renameVariable(string $oldName, string $newName)
    {
        if ($this->definition->getName() === $oldName) {
            $this->definition->setName($newName);
        }
    }

    public static function fromParameters(array $parameters): self
    {
        $variable = array_shift($parameters);
        $parts = explode('#', $variable);
        if ($parts[0] === '0') {
            throw new RuntimeException('$parts[0] is "0": ' . var_export($parts, true)); // TODO: when does this happen?
        }
        $varName = new VariableName(array_shift($parts));
        if (! empty($parts)) {
            $color = new Color(array_shift($parts));
        } else {
            $color = null;
        }
        if (! empty($parts)) {
            $color2 = new Color(array_shift($parts));
        } else {
            $color2 = null;
        }
        foreach ($parameters as $key => $parameter) {
            if (preg_match('/^([^\'][a-zA-Z+])=(.+)$/', $parameter, $match)) {
                $key = $match[1];
                $parameter = $match[2];
            }
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
        if ($color2) {
            if (method_exists($self, 'setColor2')) {
                $self->setColor2($color2);
            } else {
                throw new RuntimeException(sprintf(
                    '%s has no second color, failed to instantiate from parameters: ',
                    get_class($self)
                ));
            }
        }
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
