<?php

namespace IMEdge\Tests\RrdGraph\Instruction;

use IMEdge\RrdGraph\Data\VariableName;
use IMEdge\RrdGraph\Graph\Instruction\Line;
use IMEdge\Tests\RrdGraph\TestHelpers;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    use TestHelpers;

    public function testSimpleLineRendersCorrectly(): void
    {
        $line = new Line(new VariableName('def1'));
        $this->assertEquals('LINE1:def1', $line->__toString());
    }

    public function testFractionalWidthRendersCorrectly(): void
    {
        $line = new Line(new VariableName('def1'));
        $line->setWidth(1.5);
        $this->assertEquals('LINE1.5:def1', $line->__toString());
    }

    public function testCanBeParsedAndRendered(): void
    {
        $def = "LINE1:ifInBitsMaxPerc95#57985B:skipscale:dashes=3,5";
        $this->parseAndRender($def);
    }

    public function testCanBeParsedAndRenderedWithLegendAndDashes(): void
    {
        $def = "LINE1:ifInBitsMaxPerc95#57985B:'95 Percentile':skipscale:dashes=3,5";
        $this->parseAndRender($def);
    }
}
