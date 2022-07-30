<?php

namespace gipfl\Tests\RrdGraph\Rpn;

use gipfl\RrdGraph\Rpn\RpnExpression;
use PHPUnit\Framework\TestCase;

class RpnExpressionTest extends TestCase
{
    public function testExpressionCanBeParsedAndRendered()
    {
        $def = 'def_average_iowait,def_average_softirq,def_average_irq,def_average_nice,def_average_steal,'
            . 'def_average_guest,def_average_guest_nice,def_average_system,def_average_user,+,+,+,+,+,+,+,+';

        $expression = RpnExpression::parse($def);
        $this->assertEquals($def, (string) $expression);
    }

    public function testExpressionVariableCanBeRenamed()
    {
        $def = 'def_average_iowait,def_average_softirq,def_average_irq,def_average_nice,def_average_steal,'
            . 'def_average_guest,def_average_guest_nice,def_average_system,def_average_user,+,+,+,+,+,+,+,+';
        $new = 'def_average_iowait,def_average_softirq,def_average_irq,def_average_nice,def_average_steal,'
            . 'def_average_guest,def_average_guest_nice,def_other_system,def_average_user,+,+,+,+,+,+,+,+';

        $expression = RpnExpression::parse($def)->renameVariable('def_average_system', 'def_other_system');
        $this->assertEquals($new, (string) $expression);
    }
}
