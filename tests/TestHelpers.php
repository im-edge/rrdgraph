<?php

namespace IMEdge\Tests\RrdGraph;

use IMEdge\RrdGraph\GraphDefinitionParser;

trait TestHelpers
{
    protected function parseAndRender(string $defs, ?string $expectedString = null): void
    {
        $parser = new GraphDefinitionParser($defs);
        $this->assertEquals($expectedString ?: $defs, (string) $parser->parse());
    }
}
