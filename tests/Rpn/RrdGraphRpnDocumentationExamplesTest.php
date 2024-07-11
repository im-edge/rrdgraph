<?php

namespace gipfl\Tests\RrdGraph\Rpn;

use gipfl\RrdGraph\Rpn\RpnExpression;
use PHPUnit\Framework\TestCase;

class RrdGraphRpnDocumentationExamplesTest extends TestCase
{
    public function testParseAndRenderBooleanOperators(): void
    {
        $this->runSamples([
            'A,B,C,IF',
            '1,0,LT',
            '1,0,LE',
            '1,0,GT',
            '1,0,GE',
            '1,0,EQ',
            '1,0,NE',
            '0,UN',
            '0,ISINF',
        ]);
    }

    public function testParseAndRenderComparisonOperators(): void
    {
        $this->runSamples([
            '1,0,MIN',
            '1,0,MAX',
            '1,0,MINNAN',
            '1,0,MAXNAN',
            'value,lowerLimit,upperLimit,LIMIT',
        ]);
    }

    public function testParseAndRenderArithmeticOperators(): void
    {
        $this->runSamples([
            'mydata,8,*',
            '1,8,+',
            '4,8,-',
            '4,8,/',
            '4,8,%',
            '3,4,ADDNAN',
            'value,power,POW',
            '3,SIN',
            '3,COS',
            '3,LOG',
            '3,EXP',
            '3,SQRT',
            '3,ATAN',
            'x,y,ATAN2',
            'Y,X,ATAN2,RAD2DEG', // will convert X,Y components into an angle in degrees
            '3.1,FLOOR',
            '3.1,CEIL',
            '10,DEG2RAD',
            '10,RAD2DEG',
            '10.33,ABS',
        ]);
    }

    public function testParseAndRenderSetOperations(): void
    {
        $this->runSamples([
            '4,3,22.1,1,4,SORT',
            'v1,v2,v3,v4,v5,v6,6,SORT',
            // TODO: POP is missing:
            // 'v1,v2,v3,v4,v5,v6,6,SORT,POP,5,REV,POP,+,+,+,4,/',
            'a,b,c,d,4,AVG',
            'a,b,c,d,4,SMIN',
            'a,b,c,d,4,SMAX',
            'a,b,c,d,4,MEDIAN',
            'a,b,c,d,4,STDEV',
            // TODO:
            // 'a,b,c,d,95,4,PERCENT',
            'x,1800,TREND',
            'x,1800,TRENDNAN',

            // <shift n>,...,<shift 1>,n,<window>,x,PREDICT
            // <shift n>,...,<shift 1>,n,<window>,x,PREDICTSIGMA
            // <shift n>,...,<shift 1>,n,<window>,<percentil>,x,PREDICTPERC
            '172800,86400,2,1800,x,PREDICT',
            '172800,86400,2,1800,x,PREDICTSIGMA',
            '172800,86400,2,1800,95,x,PREDICTPERC',

            // TODO:
            // -> -n: shifts defined as a base shift and a number of time this is applied
            // <shift multiplier>,-n,<window>,x,PREDICT
            // '86400,-7,1800,value,PREDICT',
            // '86400,-7,1800,value,PREDICTSIGMA',
            // '86400,-7,1800,95,value,PREDICTPERC',

            'value,UN,0,value,lower,upper,LIMIT,UN,IF',
        ]);
    }


    public function testParseAndRenderSpecialValues(): void
    {
        $this->runSamples([
            'UNKN',
            'INF',
            'NEGINF',
            'PREV',
            // TODO:
            // PREV(vname)
            'COUNT',
        ]);
    }

    public function testParseAndRenderTimeValues(): void
    {
        $this->runSamples([
            'NOW',
            'STEPWIDTH',
            'rate,STEPWIDTH,*,PREV,ADDNAN', // go back from rate based presentations to absolute numbers
            'NEWDAY',
            'NEWWEEK',
            'NEWMONTH',
            'NEWYEAR',
            'rate,STEPWIDTH,*,NEWMONTH,0,PREV,IF,ADDNAN',
            'TIME',
            'LTIME',
        ]);
    }

    public function testParseAndRenderStackOperators(): void
    {
        $this->runSamples([
            // TODO: Processing the stack directly -> how to serialize them correctly?
            // DUP, POP, EXC,
            'DEPTH',
            // a,b,DEPTH -> a,b,2
            // 'n,COPY',
            //  a,b,c,d,2,COPY => a,b,c,d,c,d
            // 'n,INDEX',
            //  a,b,c,d,3,INDEX -> a,b,c,d,b
            // 'n,m,ROLL',
            // a,b,c,d,3,1,ROLL => a,d,b,c
            // a,b,c,d,3,-1,ROLL => a,c,d,b
        ]);
    }

    public function testParseAndRenderVariableBasedOperators(): void
    {
        $this->runSamples([
            'mydata,AVERAGE',
            // 'mydata,STDEV',
            'mydata,FIRST',
            'mydata,LAST',
            'mydata,TOTAL',
            // Check this, either docs are wrong or PERCENT is VERY weird. Seems that when there is a VDEF, no count
            // is required. Same for STDEV
            'mydata,95,PERCENT',
            'mydata,95,PERCENTNAN',
            // 'mydata,LSLSLOPE',
            'mydata,LSLSLOPE',
            'mydata,LSLINT',
            'mydata,LSLCORREL',
        ]);
    }

    public function testParseAndRenderCdefTutorialExamples(): void
    {
        $this->runSamples([
            // From doc/cdeftutorial.pod:
            'inbytes,8,*',
            'a,b,+',
            '8,4,*,4,+,4,+,8,/',
            'a,b,+,c,+,d,+,e,+',
            // 'a,b,c,d,e,+,+,+,+,+',// WRONG! -> dokufehler
            'a,b,c,d,e,+,+,+,+',
            'a,b,c,*,+',
            'b,c,*,a,+',
            'a,b,c,+,*',
            'value,UN,a,b,IF',
            'value,UN,0,value,IF',
            '0,0,value,IF',
            'number,100000,GT,UNKN,number,IF',
            'number,100000,GT,100000,number,IF',
            'TIME,begintime,GE',
            'TIME,endtime,LE',
            'TIME,begintime,GT,TIME,endtime,LE,*,ds0,UNKN,IF',
            'TIME,begintime,LT,TIME,endtime,GT,+,UNKN,ds0,IF',
            'allusers,UN,INF,UNKN,IF',
            'users1,users2,users3,users4,+,+,+,UN,INF,UNKN,IF',
            '9,5,/,cel,*,32,+',
            'idat1,UN,0,idat1,IF,idat2,UN,0,idat2,IF,+,8,*',
            'odat1,UN,0,odat1,IF,odat2,UN,0,odat2,IF,+,8,*',
            // TODO -> POP
            // 'val4,POP,TIME,7200,%,3600,LE,INF,UNKN,IF',
            'val1,val2,val3,val4,+,+,+,UN,INF,UNKN,IF',
        ]);
    }

    /**
     * @param string[] $samples
     */
    protected function runSamples(array $samples): void
    {
        foreach ($samples as $sample) {
            $this->assertEquals($sample, (string) RpnExpression::parse($sample));
        }
    }
}
