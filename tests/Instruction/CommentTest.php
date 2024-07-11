<?php

namespace IMEdge\Tests\RrdGraph\Instruction;

use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\Graph\Instruction\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testRendersGivenText(): void
    {
        $this->assertEquals("COMMENT:'Some text'", (string) new Comment(new StringType('Some text')));
    }
}
