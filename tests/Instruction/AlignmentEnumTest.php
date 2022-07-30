<?php

namespace gipfl\Tests\RrdGraph\Instruction;

use gipfl\RrdGraph\DataType\AlignmentEnum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AlignmentEnumTest extends TestCase
{
    public function testAcceptsValidAlignment()
    {
        AlignmentEnum::assertValid('left');
        AlignmentEnum::assertValid('right');
        AlignmentEnum::assertValid('justified');
        AlignmentEnum::assertValid('center');
        $this->assertTrue(true);
    }

    public function testFailsWithInvalidAlignment()
    {
        $this->expectException(InvalidArgumentException::class);
        AlignmentEnum::assertValid('leftt');
    }
}
