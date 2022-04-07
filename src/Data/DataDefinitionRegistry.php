<?php

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\ClassRegistry;

abstract class DataDefinitionRegistry
{
    use ClassRegistry;
    protected const IMPLEMENTATIONS = [
        DataCalculation::TAG => DataCalculation::class,
        DataDefinition::TAG  => DataDefinition::class,
        VariableDefinition::TAG => VariableDefinition::class,
    ];
}
