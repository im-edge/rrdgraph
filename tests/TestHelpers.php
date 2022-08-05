<?php

namespace gipfl\Tests\RrdGraph;

use gipfl\RrdGraph\GraphDefinitionParser;

trait TestHelpers
{
    protected function parseAndRender($defs)
    {
        $parser = new GraphDefinitionParser($defs);
        $this->assertEquals($defs, (string) $parser->parse());
    }
}
