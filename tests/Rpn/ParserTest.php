<?php

namespace gipfl\Tests\RrdGraph;

use gipfl\RrdGraph\GraphDefinitionParser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseAndRenderCpuGraph()
    {
        $defs = "DEF:def_average_iowait='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':iowait:AVERAGE"
            . " DEF:def_average_softirq='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':softirq:AVERAGE"
            . " DEF:def_average_irq='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':irq:AVERAGE"
            . " DEF:def_average_nice='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':nice:AVERAGE"
            . " DEF:def_average_steal='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':steal:AVERAGE"
            . " DEF:def_average_guest='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':guest:AVERAGE"
            . " DEF:def_average_guest_nice='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':guest_nice:AVERAGE"
            . " DEF:def_average_system='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':system:AVERAGE"
            . " DEF:def_average_user='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':user:AVERAGE"
            . " CDEF:total=def_average_iowait,def_average_softirq,def_average_irq,def_average_nice,def_average_steal,"
            . "def_average_guest,def_average_guest_nice,def_average_system,def_average_user,+,+,+,+,+,+,+,+"
            . " CDEF:trend_smoothed=total,3600,TRENDNAN"
            . " AREA:def_average_iowait#DDA0DD"
            . " AREA:def_average_softirq#DA70D6:STACK AREA:def_average_irq#BA55D3:STACK"
            . " AREA:def_average_nice#9932CC:STACK AREA:def_average_steal#DDA0DD:STACK"
            . " AREA:def_average_guest#DA70D6:STACK AREA:def_average_guest_nice#BA55D3:STACK"
            . " AREA:def_average_system#9932CC:STACK AREA:def_average_user#DDA0DD:STACK"
            . " LINE1.5:trend_smoothed#0095BF66";

        $this->parseAndRender($defs);
    }

    protected function testParsesAndRendersRouterExampleWithStartAndEnd()
    {
        $defs = 'DEF:ds0=router.rrd:ds0:AVERAGE'
            . ' DEF:ds0weekly=router.rrd:ds0:AVERAGE:step=7200'
            . ' DEF:ds0weekly=router.rrd:ds0:AVERAGE:start=end-1h'
            . ' DEF:ds0weekly=router.rrd:ds0:AVERAGE:start=11\\:00:end=start+1h'
            . ' DEF:ds0weekly=router.rrd:ds0:AVERAGE:daemon=collect1.example.com'

            . " AREA:def_average_iowait#DDA0DD"
            . " AREA:def_average_softirq#DA70D6:STACK AREA:def_average_irq#BA55D3:STACK"
            . " AREA:def_average_nice#9932CC:STACK AREA:def_average_steal#DDA0DD:STACK"
            . " AREA:def_average_guest#DA70D6:STACK AREA:def_average_guest_nice#BA55D3:STACK"
            . " AREA:def_average_system#9932CC:STACK AREA:def_average_user#DDA0DD:STACK"
            . " LINE1.5:trend_smoothed#0095BF66";

        $this->parseAndRender($defs);
    }

    protected function parseAndRender($defs)
    {
        $parser = new GraphDefinitionParser($defs);
        $parsed = [];
        foreach ($parser->parse() as $def) {
            $parsed[] = $def;
        }
        $this->assertEquals($defs, implode(' ', $parsed));
    }
}
