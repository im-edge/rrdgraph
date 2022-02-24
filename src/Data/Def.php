<?php

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\DataType\IntegerType;
use gipfl\RrdGraph\DataType\StringType;
use gipfl\RrdGraph\DataType\TimeInterface;
use gipfl\RrdGraph\DataType\TimeType;
use gipfl\RrdGraph\OptionalParameters;
use gipfl\RrdGraph\ParseUtils;
use InvalidArgumentException;
use function sprintf;

/**
 * Synopsis:
 *
 * TODO: Rename to DataDefinition?
 *
 * DEF:<vname>=<rrdfile>:<ds-name>:<CF>[:step=<step>][:start=<time>][:end=<time>]
 *    [:reduce=<CF>][:daemon=<address>]
 */
class Def implements DataDefinitionInterface
{
    use OptionalParameters;

    const TAG = 'DEF';
    const REQUIRED_PARAMETERS = 3;
    const OPTIONAL_PARAMETERS = [
        'step'   => IntegerType::class,
        'start'  => TimeType::class,
        'end'    => TimeType::class,
        'reduce' => StringType::class, // TODO: Consolidation function enum?
        'daemon' => StringType::class,
    ];

    // Required Parameters
    public VariableName $variable;
    public StringType $rrdFile;
    public StringType $dsName;
    /** @var StringType With PHP 8.1, this could become a backed Enum */
    public StringType $consolidationFunction;

    // Optional parameters:
    public ?IntegerType $step = null;
    public ?TimeInterface $start = null;
    public ?TimeInterface $end = null;
    public ?StringType $reduce = null;
    public ?StringType $daemon = null;

    public function __construct(
        VariableName $variableName,
        StringType $rrdFile,
        StringType $dsName,
        StringType $consolidationFunction
    ) {
        $this->variable = $variableName;
        $this->rrdFile = $rrdFile;
        $this->dsName = $dsName;
        $this->consolidationFunction = $consolidationFunction;
    }

    protected static function fromRequiredParameters(array &$parameters): Def
    {
        static::assertRequiredParameterCount($parameters);
        list($varName, $file) = ParseUtils::splitKeyValue(array_shift($parameters), '=');

        return new static(
            new VariableName(StringType::parse($varName)),
            StringType::parse($file),
            StringType::parse(array_shift($parameters)),
            StringType::parse(array_shift($parameters))
        );
    }

    protected static function assertRequiredParameterCount(array $parameters)
    {
        if (count($parameters) < static::REQUIRED_PARAMETERS) {
            throw new InvalidArgumentException(sprintf(
                "'%s' expects at least %d parameters, got: %s",
                static::TAG,
                static::REQUIRED_PARAMETERS,
                json_encode($parameters)
            ));
        }
    }

    public static function fromParameters(array $parameters): Def
    {
        $self = static::fromRequiredParameters($parameters);
        $self->setOptionalParameters($parameters);
        return $self;
    }

    public function __toString(): string
    {
        return sprintf(
            self::TAG . ':%s=%s:%s:%s',
            $this->variable,
            $this->rrdFile,
            $this->dsName,
            $this->consolidationFunction
        ) . $this->renderOptionalParameters();
    }
}
