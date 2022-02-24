<?php

namespace gipfl\Tests\RrdGraph;

use gipfl\RrdGraph\Graph\Instruction\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testRendersGivenText()
    {
        $this->assertEquals("COMMENT:'Some text'", (string) new Comment('Some text'));
    }
}
