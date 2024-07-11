<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Data;

use IMEdge\RrdGraph\DataType\IntegerType;
use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\DataType\TimeInterface;
use IMEdge\RrdGraph\DataType\TimeType;
use IMEdge\RrdGraph\OptionalParameters;
use InvalidArgumentException;
use function sprintf;

/**
 * Synopsis:
 *
 * DEF:<vname>=<rrdfile>:<ds-name>:<CF>[:step=<step>][:start=<time>][:end=<time>]
 *    [:reduce=<CF>][:daemon=<address>]
 */
class DataDefinition implements ExpressionInterface
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

    final public function __construct(
        StringType $rrdFile,
        StringType $dsName,
        StringType $consolidationFunction
    ) {
        $this->rrdFile = $rrdFile;
        $this->dsName = $dsName;
        $this->consolidationFunction = $consolidationFunction;
    }

    protected static function fromRequiredParameters(array &$parameters): DataDefinition
    {
        static::assertRequiredParameterCount($parameters);

        return new DataDefinition(
            StringType::parse(array_shift($parameters)),
            StringType::parse(array_shift($parameters)),
            StringType::parse(array_shift($parameters))
        );
    }

    protected static function assertRequiredParameterCount(array $parameters): void
    {
        if (count($parameters) < static::REQUIRED_PARAMETERS) {
            throw new InvalidArgumentException(sprintf(
                "'%s' expects at least %d parameters, got: %s",
                static::TAG,
                static::REQUIRED_PARAMETERS,
                var_export($parameters, true)
            ));
        }
    }

    public static function fromParameters(array $parameters): DataDefinition
    {
        $self = DataDefinition::fromRequiredParameters($parameters);
        $self->setOptionalParameters($parameters);

        return $self;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s:%s:%s',
            $this->rrdFile,
            $this->dsName,
            $this->consolidationFunction
        ) . $this->renderOptionalParameters();
    }

    public function getTag(): string
    {
        return self::TAG;
    }
}
