<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Data;

use InvalidArgumentException;

/**
 * Variable names (vname) must be made up strings of the following characters...
 *
 *     A-Z, a-z, 0-9, _, -
 *
 * ...and a maximum length of 255 characters.
 */
class VariableName
{
    private const EXPRESSION = '/^[A-Za-z_-][A-Za-z0-9_-]{0,255}$/';
    protected string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        if (! static::isValid($name)) {
            throw new InvalidArgumentException("'$name' is not a valid Variable Name (vname)");
        }

        $this->name = $name;

        return $this;
    }

    public function equals(VariableName $variableName): bool
    {
        return $variableName->__toString() === $this->__toString();
    }

    public static function isValid(string $string): bool
    {
        return preg_match(self::EXPRESSION, $string) > 0;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
