<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\DataType;

use InvalidArgumentException;

use function in_array;

/**
 * We have no enums on PHP 7.4
 */
class AlignmentEnum implements DataTypeInterface
{
    public const LEFT      = 'left';
    public const RIGHT     = 'right';
    public const JUSTIFIED = 'justified';
    public const CENTER    = 'center';

    protected const VALID_ALIGNMENTS = [
        self::LEFT,
        self::RIGHT,
        self::JUSTIFIED,
        self::CENTER,
    ];
    protected string $alignment;

    public function __construct(string $alignment)
    {
        static::assertValid($alignment);
        $this->alignment = $alignment;
    }

    public static function assertValid(string $string): void
    {
        if (! in_array($string, self::VALID_ALIGNMENTS)) {
            throw new InvalidArgumentException(
                "$string is not a valid alignment"
            );
        }
    }

    public function __toString(): string
    {
        return $this->alignment;
    }

    /**
     * @param string $string
     * @return AlignmentEnum
     */
    public static function parse(string $string): DataTypeInterface
    {
        return new AlignmentEnum($string);
    }
}
