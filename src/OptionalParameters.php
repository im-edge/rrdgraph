<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph;

use IMEdge\RrdGraph\DataType\DataTypeInterface;
use RuntimeException;

use function array_keys;
use function sprintf;

trait OptionalParameters
{
    /**
     * @param string[] $parameters
     */
    protected function setOptionalParameters(array $parameters): void
    {
        foreach ($parameters as $parameter) {
            list($param, $value) = ParseUtils::splitKeyValue($parameter, '=');
            $class = static::OPTIONAL_PARAMETERS[$param] ?? null;
            /** @var ?DataTypeInterface $class */
            if ($class) {
                $this->$param = $class::parse($value);
            } else {
                throw new RuntimeException(sprintf(
                    "'%s' is not a known parameter for %s",
                    $param,
                    static::TAG
                ));
            }
        }
    }

    protected function renderOptionalParameters(): string
    {
        $string = '';
        foreach (array_keys(static::OPTIONAL_PARAMETERS) as $parameter) {
            if ($this->$parameter !== null) {
                $string .= Render::namedParameter((string) $parameter, $this->$parameter);
            }
        }

        return $string;
    }
}
