<?php

namespace gipfl\Tests\RrdGraph\Data;

use gipfl\RrdGraph\Data\Assignment;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\IntegerType;
use gipfl\RrdGraph\Rpn\Add;
use gipfl\RrdGraph\Rpn\Multiply;
use gipfl\RrdGraph\Rpn\RpnExpression;
use PHPUnit\Framework\TestCase;

class AssignmentTest extends TestCase
{
    public function testDefineAndRenderMultiplication()
    {
        $def = new Assignment('DEF', new VariableName('result'), new RpnExpression(new Multiply(), [5, 6]));
        $this->assertEquals('DEF:result=6,5,*', (string) $def);
    }

    public function testDefineAndRenderNestedExpressionWithRenamedVariables()
    {
        $def = new Assignment('DEF', new VariableName('uptime'), new RpnExpression(new Multiply(), [
            new RpnExpression(new Add(), [
                new IntegerType(10),
                new VariableName('subValue')
            ]),
            new VariableName('test')
        ]));
        $def->getRpnExpression()->renameVariable('test', 'changed')->renameVariable('subValue', 'sub');

        $this->assertEquals('DEF:uptime=changed,sub,10,+,*', (string) $def);
    }
}
