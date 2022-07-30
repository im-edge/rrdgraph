<?php

namespace gipfl\Tests\RrdGraph\Instruction;

use gipfl\RrdGraph\DataType\StringType;
use gipfl\RrdGraph\Graph\Instruction\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testRendersGivenText()
    {
        $this->assertEquals("COMMENT:'Some text'", (string) new Comment(new StringType('Some text')));
    }
}
