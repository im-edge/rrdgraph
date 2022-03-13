<?php

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\Render;

class RrdGraphData
{
    /** @var Def[] Data Definition */
    protected array $dataDefinitions = [];

    /** @var CDef[] Data Calculation */
    protected array $dataCalculations = [];

    /** @var VDef[] Variable Definitions */
    protected array $variableDefinitions = [];

    /** @var string[] */
    protected array $usedAliases = [];

    public function def($filename, $ds, $cf)
    {
        $filename = Render::string($filename);
        $quotedDs = Render::string($ds);
        $def = "$filename:$quotedDs:$cf";
        if (isset($this->defs[$def])) {
            return $this->defs[$def];
        }
        $alias = $this->getUniqueAlias('def_' . strtolower($cf) . '_' . $ds);
        $this->defs[$def] = $alias;

        return $alias;
    }

    public function cdef($expression, $preferredAlias = null): string
    {
        if (isset($this->cdefs[$expression])) {
            return $this->cdefs[$expression];
        }
        if ($preferredAlias === null) {
            $preferredAlias = 'cdef__1';
        }
        $alias = $this->getUniqueAlias($preferredAlias);
        $this->cdefs[$expression] = $alias;

        return $alias;
    }

    public function vdef($expression, $preferredAlias = null): string
    {
        if (isset($this->vdefs[$expression])) {
            return $this->vdefs[$expression];
        }
        if ($preferredAlias === null) {
            $preferredAlias = 'vdef__1';
        }
        $alias = $this->getUniqueAlias($preferredAlias);
        $this->vdefs[$expression] = $alias;

        return $alias;
    }

    protected function getUniqueAlias($name): string
    {
        while (isset($this->usedAliases[$name])) {
            $name = $this->makeNextName($name);
        }

        $this->usedAliases[$name] = true;

        return $name;
    }

    protected function makeNextName($name): string
    {
        if (preg_match('/^(.+__)(\d+)$/', $name, $match)) {
            return $match[1] . ((int) $match[2] + 1);
        } else {
            return $name . '__2';
        }
    }

    public function getInstructions()
    {
        $instructions = [];
        foreach ($this->defs as $def => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "DEF:$alias=$def";
        }
        foreach ($this->cdefs as $expression => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "CDEF:$alias=$expression";
        }
        foreach ($this->vdefs as $expression => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "VDEF:$alias=$expression";
        }

        return array_merge($instructions, $this->instructions);
    }
}
