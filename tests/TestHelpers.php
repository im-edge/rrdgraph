<?php

namespace gipfl\Tests\RrdGraph;

use gipfl\RrdGraph\GraphDefinitionParser;

trait TestHelpers
{
    protected function parseAndRender(string $defs, ?string $expectedString = null)
    {
        $parser = new GraphDefinitionParser($defs);
        $this->assertEquals($expectedString ?: $defs, (string) $parser->parse());
    }
}
