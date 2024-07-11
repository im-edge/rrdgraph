<?php

namespace IMEdge\Tests\RrdGraph\Rpn;

use IMEdge\RrdGraph\GraphDefinitionParser;
use IMEdge\Tests\RrdGraph\TestHelpers;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    use TestHelpers;

    public function testParsesAndRendersAStackedCpuGraph(): void
    {
        $defs = "DEF:def_average_rta=19/8b/198b6fbaec8a4b2b8809a3b625bf1752.rrd:rta:AVERAGE"
            . " DEF:def_min_rta=19/8b/198b6fbaec8a4b2b8809a3b625bf1752.rrd:rta:MIN"
            . " DEF:def_max_rta=19/8b/198b6fbaec8a4b2b8809a3b625bf1752.rrd:rta:MAX"
            . " CDEF:cdef__1=def_average_rta,0,*"
            . " CDEF:cdef__2=def_average_rta,def_min_rta,-,10,/"
            . " CDEF:cdef__3=def_max_rta,def_average_rta,-,10,/"
            . " VDEF:vdef__1=def_max_rta,100,PERCENT LINE1:cdef__1#00000000"
            . " AREA:def_min_rta::skipscale AREA:cdef__2#0095BF0a::STACK"
            . " AREA:cdef__2#0095BF14::STACK AREA:cdef__2#0095BF1e::STACK"
            . " AREA:cdef__2#0095BF28::STACK AREA:cdef__2#0095BF32::STACK"
            . " AREA:cdef__2#0095BF3c::STACK AREA:cdef__2#0095BF46::STACK"
            . " AREA:cdef__2#0095BF50::STACK AREA:cdef__2#0095BF5a::STACK"
            . " AREA:cdef__2#0095BF64::STACK AREA:cdef__3#0095BF64::STACK:skipscale"
            . " AREA:cdef__3#0095BF5a::STACK:skipscale AREA:cdef__3#0095BF50::STACK:skipscale"
            . " AREA:cdef__3#0095BF46::STACK:skipscale AREA:cdef__3#0095BF3c::STACK:skipscale"
            . " AREA:cdef__3#0095BF32::STACK:skipscale AREA:cdef__3#0095BF28::STACK:skipscale"
            . " AREA:cdef__3#0095BF1e::STACK:skipscale AREA:cdef__3#0095BF14::STACK:skipscale"
            . " AREA:cdef__3#0095BF0a::STACK:skipscale LINE1:def_average_rta#0095BF LINE1:vdef__1";

        $this->parseAndRender($defs);
    }
    public function testParseAndRenderCpuGraph(): void
    {
        $defs = "DEF:def_average_iowait=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:iowait:AVERAGE"
            . " DEF:def_average_softirq=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:softirq:AVERAGE"
            . " DEF:def_average_irq=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:irq:AVERAGE"
            . " DEF:def_average_nice=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:nice:AVERAGE"
            . " DEF:def_average_steal=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:steal:AVERAGE"
            . " DEF:def_average_guest=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:guest:AVERAGE"
            . " DEF:def_average_guest_nice=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:guest_nice:AVERAGE"
            . " DEF:def_average_system=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:system:AVERAGE"
            . " DEF:def_average_user=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:user:AVERAGE"
            . " CDEF:total=def_average_iowait,def_average_softirq,def_average_irq,def_average_nice,def_average_steal,"
            . "def_average_guest,def_average_guest_nice,def_average_system,def_average_user,+,+,+,+,+,+,+,+"
            . " CDEF:trend_smoothed=total,3600,TRENDNAN"
            . " AREA:def_average_iowait#DDA0DD"
            . " AREA:def_average_softirq#DA70D6::STACK AREA:def_average_irq#BA55D3::STACK"
            . " AREA:def_average_nice#9932CC::STACK AREA:def_average_steal#DDA0DD::STACK"
            . " AREA:def_average_guest#DA70D6::STACK AREA:def_average_guest_nice#BA55D3::STACK"
            . " AREA:def_average_system#9932CC::STACK AREA:def_average_user#DDA0DD::STACK"
            . " LINE1.5:trend_smoothed#0095BF66";

        $this->parseAndRender($defs);
    }

    public function testParsesAndRendersRrdGraphExampleWithMultipleResolutions(): void
    {
        $defs = 'DEF:ds0a=/home/rrdtool/data/router1.rrd:ds0:AVERAGE'
            . ' DEF:ds0b=/home/rrdtool/data/router1.rrd:ds0:AVERAGE:step=1800'
            . ' DEF:ds0c=/home/rrdtool/data/router1.rrd:ds0:AVERAGE:step=7200'
            . " LINE1:ds0a#0000FF:'default resolution\l'"
            . " LINE1:ds0b#00CCFF:'resolution 1800 seconds per interval\l'"
            . " LINE1:ds0c#FF00FF:'resolution 7200 seconds per interval\l'";

        $this->parseAndRender($defs);
    }

    public function testParsesAndRendersNicelyFormattedLegendSection(): void
    {
        $defs = 'DEF:ds0=/home/rrdtool/data/router1.rrd:ds0:AVERAGE'
            . ' DEF:ds1=/home/rrdtool/data/router1.rrd:ds1:AVERAGE'

            // consolidation occurs here
            . ' CDEF:ds0bits=ds0,8,*'
            . ' CDEF:ds1bits=ds1,8,*'

            . ' VDEF:ds0max=ds0,MAXIMUM'
            . ' VDEF:ds0avg=ds0,AVERAGE'
            . ' VDEF:ds0min=ds0,MINIMUM'
            . ' VDEF:ds0pct=ds0,95,PERCENT'
            . ' VDEF:ds1max=ds1,MAXIMUM'
            . ' VDEF:ds1avg=ds1,AVERAGE'
            . ' VDEF:ds1min=ds1,MINIMUM'
            . ' VDEF:ds1pct=ds1,95,PERCENT'
            // 10 spaces to move text to the right
            . " COMMENT:'          '"
            // the column titles have to be as wide as the columns
            . " COMMENT:'Maximum    '"
            . " COMMENT:'Average    '"
            . " COMMENT:'Minimum    '"
            . " COMMENT:'95th percentile\l'"
            . " AREA:ds0bits#00C000:'Inbound '"
            . " GPRINT:ds0max:'%6.2lf %Sbps'"
            . " GPRINT:ds0avg:'%6.2lf %Sbps'"
            . " GPRINT:ds0min:'%6.2lf %Sbps'"
            . " GPRINT:ds0pct:'%6.2lf %Sbps\l'"
            . " LINE1:ds1bits#0000FF:Outbound"
            . " GPRINT:ds1max:'%6.2lf %Sbps'"
            . " GPRINT:ds1avg:'%6.2lf %Sbps'"
            . " GPRINT:ds1min:'%6.2lf %Sbps'"
            . " GPRINT:ds1pct:'%6.2lf %Sbps\l'";

        $this->parseAndRender($defs);
    }

    protected function testParsesAndRendersOffsettingALineOnTheYAxis(): void
    {
        // Depending on your needs you can do this in two ways:
        $defs = 'DEF:mydata=my.rrd:ds:AVERAGE'
            // this will also influence any other command that uses "data"
            . ' CDEF:data=mydata,100,+'
            . ' LINE1:data#FF0000:"Data with offset"'
            // Graph the original data, with an offset
            // no color in the first line, so it is not visible
            . ' LINE1:100'
            // the second line gets stacked on top of the first one
            . ' LINE1:mydata#FF0000:"Data with offset":STACK';
        $expected =  'DEF:mydata=my.rrd:ds:AVERAGE'
            . ' CDEF:data=mydata,100,+'
            . " LINE1:data#FF0000:'Data with offset'"
            . ' LINE1:100'
            . " LINE1:mydata#FF0000:'Data with offset':STACK";
        $this->parseAndRender($defs, $expected);
    }
}
