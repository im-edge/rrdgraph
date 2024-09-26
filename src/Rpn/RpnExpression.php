<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

use IMEdge\RrdGraph\Data\ExpressionInterface;
use IMEdge\RrdGraph\Data\VariableName;
use InvalidArgumentException;
use RuntimeException;

class RpnExpression implements ExpressionInterface
{
    protected Operator $operator;
    protected array $parameters;
    protected array $variadicParameters;

    /**
     * Expression constructor.
     * @param Operator $operator
     * @param array $parameters
     * @param array $variadicParameters
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

    public function listUsedVariableNames(): array
    {
        $names = [];
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof VariableName) {
                $names[] = (string) $parameter;
            } elseif ($parameter instanceof RpnExpression) {
                foreach ($parameter->listUsedVariableNames() as $name) {
                    $names[] = $name;
                }
            }
        }

        return $names;
    }

    public function renameVariable($oldName, $newName): self
    {
        if ($this->operator instanceof RemoveTopStackElement) { // TODO: generic interface?
            if ($folluwUp = $this->operator->getFollowUpExpression()) {
                $folluwUp->renameVariable($oldName, $newName);
            }
        }
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof VariableName && $parameter->getName() === $oldName) {
                $parameter->setName($newName);
            } elseif ($parameter instanceof RpnExpression) {
                $parameter->renameVariable($oldName, $newName);
            }
        }

        return $this;
    }

    public static function parse(string $string): RpnExpression
    {
        return static::fromParameters(explode(',', $string));
    }

    public static function fromParameters(array $parameters): RpnExpression
    {
        $stack = $parameters;
        $operatorName = array_pop($stack);
        if (strlen($operatorName) === 0) {
            throw new InvalidArgumentException(sprintf(
                "'%s' is not a valid RPN expression",
                implode(',', $stack)
            ));
        }

        $expression = static::consumeStackOperator($operatorName, $stack);

        // TODO: better common logic / interface for stack-manipulating operators?
        while (end($stack) === 'POP') {
            $pop = static::consumeStackOperator(array_pop($stack), $stack);
            $operator = $pop->operator;
            assert($operator instanceof RemoveTopStackElement);
            $operator->setFollowupExpression($expression);
            $expression = $pop;
        }
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
            throw new RuntimeException('Arity (variadic parameter count) expected, got ' . var_export($count, true));
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

    protected function renderFollowUp(): string
    {
        $followUp = '';
        $operator = $this->operator;
        if ($operator instanceof RemoveTopStackElement) {
            if ($expression = $operator->getFollowUpExpression()) {
                $followUp .= ',' . $expression;
            }
        }

        return $followUp;
    }

    public function __toString(): string
    {
        return $this->renderParams() . $this->operator::NAME . $this->renderFollowUp();
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

        if (is_string($value) && VariableName::isValid($value)) {
            $value = new VariableName($value);
        }

        return $value;
    }
}
