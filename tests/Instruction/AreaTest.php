<?php

namespace IMEdge\Tests\RrdGraph\Instruction;

use IMEdge\RrdGraph\Color;
use IMEdge\RrdGraph\Data\VariableName;
use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\Graph\Instruction\Area;
use IMEdge\Tests\RrdGraph\TestHelpers;
use PHPUnit\Framework\TestCase;

class AreaTest extends TestCase
{
    use TestHelpers;

    public function testSimpleAreaRendersCorrectly(): void
    {
        $area = new Area(new VariableName('def1'));
        $this->assertEquals('AREA:def1', $area->__toString());
    }

    public function testStackCanBeConfigured(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setStack();
        $this->assertTrue($area->isStack());
    }

    public function testStackRendersCorrectly(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setStack();
        $this->assertEquals('AREA:def1::STACK', $area->__toString());
    }

    public function testLegendRendersCorrectly(): void
    {
        $area = new Area(new VariableName('def1'), null, new StringType('This is a legend'));
        $this->assertEquals("AREA:def1:'This is a legend'", $area->__toString());
    }

    public function testSkipScaleCanBeConfigured(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setSkipScale();
        $this->assertTrue($area->isSkipScale());
    }

    public function testSkipScaleRendersCorrectly(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setSkipScale();
        $this->assertEquals('AREA:def1::skipscale', $area->__toString());
    }

    public function testSkipScaleAndStackCanBeConfiguredTogether(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setSkipScale();
        $area->setStack();
        $this->assertTrue($area->isSkipScale());
        $this->assertTrue($area->isStack());
    }

    public function testSkipScaleAndStackRenderTogether(): void
    {
        $area = new Area(new VariableName('def1'));
        $area->setSkipScale();
        $area->setStack();
        $this->assertEquals('AREA:def1::STACK:skipscale', $area->__toString());
    }

    public function testRendersGivenText(): void
    {
        $area = new Area(new VariableName('cdef'), new Color('0095BF32'));
        $area->setStack();
        $area->setSkipScale();
        $this->assertEquals(
            "AREA:cdef#0095BF32::STACK:skipscale",
            (string) $area
        );
    }

    public function testCanBeParsedAndRendered(): void
    {
        $def = 'AREA:cdef#0095BF32::STACK:skipscale';
        $this->parseAndRender($def);
    }

    public function testSupportsSecondColor(): void
    {
        $def = 'AREA:cdef#0095BF32#ff95BF32::STACK:skipscale';
        $this->parseAndRender($def);
    }
}
