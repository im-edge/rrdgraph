<?php

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\Render;

class RrdGraphData
{
    /** @var DataDefinition[] Data Definition */
    protected array $dataDefinitions = [];

    /** @var DataCalculation[] Data Calculation */
    protected array $dataCalculations = [];

    /** @var VariableDefinition[] Variable Definitions */
    protected array $variableDefinitions = [];

    /** @var string[] */
    protected array $usedAliases = [];

    public function addDataDefinition($filename, $ds, $cf)
    {
        $filename = Render::string($filename);
        $quotedDs = Render::string($ds);
        $def = "$filename:$quotedDs:$cf";
        if (isset($this->dataDefinitions[$def])) {
            return $this->dataDefinitions[$def];
        }
        $alias = $this->getUniqueAlias('def_' . strtolower($cf) . '_' . $ds);
        $this->dataDefinitions[$def] = $alias;

        return $alias;
    }

    public function addDataCalculation($expression, $preferredAlias = null): string
    {
        if (isset($this->dataCalculations[$expression])) {
            return $this->dataCalculations[$expression];
        }
        if ($preferredAlias === null) {
            $preferredAlias = 'cdef__1';
        }
        $alias = $this->getUniqueAlias($preferredAlias);
        $this->dataCalculations[$expression] = $alias;

        return $alias;
    }

    public function addVariableDefinition($expression, $preferredAlias = null): string
    {
        if (isset($this->variableDefinitions[$expression])) {
            return $this->variableDefinitions[$expression];
        }
        if ($preferredAlias === null) {
            $preferredAlias = 'vdef__1';
        }
        $alias = $this->getUniqueAlias($preferredAlias);
        $this->variableDefinitions[$expression] = $alias;

        return $alias;
    }

    public function getDefinition(string $alias): DataDefinitionInterface
    {
        if (isset($this->dataDefinitions[$alias])) {
            return $this->dataDefinitions[$alias];
        }
        if (isset($this->dataCalculations[$alias])) {
            return $this->dataCalculations[$alias];
        }
        if (isset($this->variableDefinitions[$alias])) {
            return $this->variableDefinitions[$alias];
        }

        throw new \OutOfBoundsException("No definition named '$alias' has been registered");
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

    public function getInstructions(): array
    {
        $instructions = [];
        foreach ($this->dataDefinitions as $def => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "DEF:$alias=$def";
        }
        foreach ($this->dataCalculations as $expression => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "CDEF:$alias=$expression";
        }
        foreach ($this->variableDefinitions as $expression => $alias) {
            $alias = Render::string($alias);
            $instructions[] = "VDEF:$alias=$expression";
        }

        return $instructions;
    }
}
