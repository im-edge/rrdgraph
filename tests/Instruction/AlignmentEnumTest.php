<?php

namespace IMEdge\Tests\RrdGraph\Instruction;

use IMEdge\RrdGraph\DataType\AlignmentEnum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AlignmentEnumTest extends TestCase
{
    public function testAcceptsValidAlignment(): void
    {
        AlignmentEnum::assertValid('left');
        AlignmentEnum::assertValid('right');
        AlignmentEnum::assertValid('justified');
        AlignmentEnum::assertValid('center');
        $this->assertTrue(true);
    }

    public function testFailsWithInvalidAlignment(): void
    {
        $this->expectException(InvalidArgumentException::class);
        AlignmentEnum::assertValid('leftt');
    }
}
