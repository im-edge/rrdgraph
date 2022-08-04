<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\DataType\StringType;
use gipfl\RrdGraph\GraphDefinitionParser;
use gipfl\RrdGraph\ParseUtils;
use gipfl\RrdGraph\Rpn\RpnExpression;
use OutOfBoundsException;
use RuntimeException;

class Assignment
{
    const TAG_DATA_DEFINITION = 'DEF';
    const TAG_DATA_CALCULATION = 'CDEF';
    const TAG_VARIABLE_DEFINITION = 'VDEF';
    const ALLOWED_TAGS = [
        self::TAG_DATA_DEFINITION,
        self::TAG_DATA_CALCULATION,
        self::TAG_VARIABLE_DEFINITION,
    ];
    protected VariableName $variableName;
    protected ExpressionInterface $expression;
    protected string $tag;

    public function __construct(string $tag, VariableName $variableName, ExpressionInterface $expression)
    {
        if (self::isValidTag($tag)) {
            $this->tag = $tag;
        } else {
            throw new OutOfBoundsException('"$tag" is not a valid tag for data definition assignments');
        }
        $this->variableName = $variableName;
        $this->expression = $expression;
    }

    public static function parse(string $string): Assignment
    {
        $parser = new GraphDefinitionParser($string);
        $type = $parser->readType();
        $assignment = $parser->parseParameters();

        return static::fromAssignment($type, iterator_to_array($assignment));
    }

    public static function fromAssignment(string $tag, array $assignment): Assignment
    {
        static::assertValidTag($tag);
        $parts = ParseUtils::splitKeyValue(array_shift($assignment), '=');
        array_unshift($assignment, $parts[1]);
        $varName = new VariableName(StringType::parse($parts[0])->getRawString());
        if ($tag === self::TAG_DATA_DEFINITION) {
            $expression = DataDefinition::fromParameters($assignment);
        } else {
            $expression = RpnExpression::parse($assignment[0]);
        }

        return new Assignment($tag, $varName, $expression);
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getExpression(): ExpressionInterface
    {
        return $this->expression;
    }

    public function getVariableName(): VariableName
    {
        return $this->variableName;
    }

    public function getRpnExpression(): RpnExpression
    {
        if ($this->expression instanceof RpnExpression) {
            return $this->expression;
        }

        throw new RuntimeException(sprintf('%s Assignment has no RPN expression', $this->tag));
    }

    public static function assertValidTag($tag)
    {
        if (!self::isValidTag($tag)) {
            throw new OutOfBoundsException("'$tag' is not a valid tag for data definition assignments");
        }
    }

    public static function isValidTag($tag): bool
    {
        return in_array($tag, self::ALLOWED_TAGS);
    }

    public function __toString(): string
    {
        return $this->tag . ':' . $this->variableName . '=' . $this->expression;
    }
}
