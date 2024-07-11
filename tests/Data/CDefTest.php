<?php

namespace IMEdge\Tests\RrdGraph\Data;

use IMEdge\RrdGraph\Data\Assignment;
use PHPUnit\Framework\TestCase;

class CDefTest extends TestCase
{
    public function testParsesAndRendersCdefString(): void
    {
        $in = "CDEF:'trend_smoothed'=total,3600,TRENDNAN";
        $out = "CDEF:trend_smoothed=total,3600,TRENDNAN";
        $this->assertEquals($out, (string) Assignment::parse($in));

        $in = "CDEF:'total'=iowait,softirq,irq,nice,steal,guest,guest_nice,system,user,+,+,+,+,+,+,+,+";
        $out = 'CDEF:total=iowait,softirq,irq,nice,steal,guest,guest_nice,system,user,+,+,+,+,+,+,+,+';
        $this->assertEquals($out, (string) Assignment::parse($in));
    }
}
