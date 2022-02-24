<?php

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\ClassRegistry;

abstract class DataDefinitionRegistry
{
    use ClassRegistry;
    private const IMPLEMENTATIONS = [
        CDef::TAG => CDef::class,
        Def::TAG  => Def::class,
        VDef::TAG => VDef::class,
    ];
}
