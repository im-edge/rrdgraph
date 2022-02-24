<?php

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\ClassRegistry;

abstract class InstructionRegistry
{
    use ClassRegistry;

    private const IMPLEMENTATIONS = [
        Area::TAG      => Area::class,
        Comment::TAG   => Comment::class,
        GPrint::TAG    => GPrint::class,
        HRule::TAG     => HRule::class,
        Line::TAG      => Line::class,
        PrintGraphInstruction::TAG => PrintGraphInstruction::class,
        Shift::TAG     => Shift::class,
        TextAlign::TAG => TextAlign::class,
        Tick::TAG      => Tick::class,
        VRule::TAG     => VRule::class,
    ];
}
