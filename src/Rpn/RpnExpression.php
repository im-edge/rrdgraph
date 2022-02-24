<?php

namespace gipfl\RrdGraph\Rpn;

use InvalidArgumentException;
use RuntimeException;

class RpnExpression
{
    protected Operator $operator;
    protected array $parameters;
    protected array $variadicParameters;

    /**
     * Expression constructor.
     * @param Operator $operator
     * @param array $parameters
     */
    public function __construct(Operator $operator, array $parameters = [], array $variadicParameters = [])
    {
        $this->operator = $operator;
        $arity = $operator->getParameterCount();
        if (count($parameters) !== $arity) {
            throw new InvalidArgumentException(sprintf(
                '%s requires %d parameter(s), got %d',
                $operator::NAME,
                $arity,
                count($parameters)
            ));
        }
        $this->parameters = $parameters;
        $this->variadicParameters = $variadicParameters;
    }

    public static function parse(string $string): RpnExpression
    {
        $stack = explode(',', $string);
        $operatorName = array_pop($stack);
        if ($operatorName === null) {
            throw new InvalidArgumentException("'$string' is not a valid RPN expression");
        }

        $expression = static::consumeStackOperator($operatorName, $stack);
        if (! empty($stack)) {
            throw new RuntimeException(sprintf(
                "Stack not empty, still contains: '%s'",
                implode(',', $stack)
            ));
        }

        return $expression;
    }

    protected static function consumeStackOperator($operatorName, array &$stack): RpnExpression
    {
        $class = OperatorRegistry::getClass($operatorName);
        /** @var Operator $operator */
        $operator = new $class;
        if ($operator->isVariadic() && $operator->variadicCountIsFirst()) {
            $variadicCount = self::requireVariadicCount($stack, $operatorName);
        } else {
            $variadicCount = null;
        }
        $params = self::requireStackParams($stack, $operator->getParameterCount(), $operatorName);
        if ($operator->isVariadic()) {
            if ($variadicCount === null) {
                $variadicCount = self::requireVariadicCount($stack, $operatorName);
            }
            $variadic = self::requireStackParams($stack, $variadicCount, $operatorName);
        } else {
            $variadic = [];
        }

        return new RpnExpression($operator, $params, $variadic);
    }

    protected static function requireVariadicCount(array &$stack, string $operatorName): int
    {
        $count = self::requireStackValue($stack, $operatorName);
        if (!ctype_digit($count)) {
            throw new RuntimeException('Arity (variadic parameter count) expected, got ' . $count);
        }

        return (int) $count;
    }

    protected static function requireStackParams(array &$stack, int $count, string $operatorName): array
    {
        $params = [];
        for ($i = 0; $i < $count; $i++) {
            $params[] = self::requireStackValue($stack, $operatorName);
        }

        return $params;
    }

    protected function renderParams(): string
    {
        $string = '';
        $variadic = $this->operator->isVariadic();
        if ($variadic) {
            foreach (array_reverse($this->variadicParameters) as $param) {
                $string .= "$param,";
            }
            $variadicFirst = $this->operator->variadicCountIsFirst();
            if (!$variadicFirst) {
                $string .= count($this->variadicParameters) . ',';
            }
        } else {
            $variadicFirst = false;
        }
        foreach (array_reverse($this->parameters) as $param) {
            $string .= "$param,";
        }
        if ($variadicFirst) {
            $string .= count($this->variadicParameters) . ',';
        }

        return $string;
    }

    public function __toString()
    {
        return $this->renderParams() . $this->operator::NAME;
    }

    protected static function requireStackValue(&$stack, string $operatorName)
    {
        if (null === ($value = array_pop($stack))) {
            throw new RuntimeException("Stack under-run for $operatorName");
        }
        if (ctype_alnum($value) || in_array($value, ['+', '-', '*', '/', '%'])) {
            // Operator or reference
            if (OperatorRegistry::isKnown($value)) {
                // Hint: this is recursive. A flat variant could be a better alternative
                $value = RpnExpression::consumeStackOperator($value, $stack);
            }
        }

        return $value;
    }
}
