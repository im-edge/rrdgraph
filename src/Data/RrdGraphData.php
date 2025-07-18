<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Data;

use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\Render;

class RrdGraphData
{
    // HINT, TODO: this class is still work in progress.
    // HINT: Is it obsolete, since there is now GraphDefinition?
    // Using rendered keys for normalization still needs to be finished
    // uniqueness based on RPN will not work, as variable names might change

    /** @var array<string, string> definition => alias */
    protected array $dataDefinitions = [];

    /** @var array<string, DataDefinition|DataCalculation|VariableDefinition> */
    protected array $data = [];

    /** @var array<string, string> rpn =>  */
    protected array $dataCalculations = [];

    /** @var array <string, string> Variable Definitions */
    protected array $variableDefinitions = [];

    public function addDataDefinition(StringType $filename, StringType $ds, StringType $cf): string
    {
        // TODO: ConsolidationFunction enum for StringType?
        $def =  "$filename:$ds:$cf";
        if (isset($this->dataDefinitions[$def])) {
            $alias = $this->dataDefinitions[$def];
        } else {
            $alias = $this->getUniqueAlias('def_' . strtolower($cf->getRawString()) . '_' . $ds);
            $this->dataDefinitions[$def] = $alias;
            $this->data[$alias] = new DataDefinition($filename, $ds, $cf);
        }

        return $alias;
    }

    public function addDataCalculation(string $expression, ?string $preferredAlias = null): string
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

    public function addVariableDefinition(string $expression, ?string $preferredAlias = null): string
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

    public function getDefinition(string $alias): ExpressionInterface
    {
        if (isset($this->data[$alias])) {
            return $this->data[$alias];
        }

        throw new \OutOfBoundsException("No definition named '$alias' has been registered");

        /**
        if (isset($this->dataDefinitions[$alias])) {
            return DataDefinition::fromParameters($this->dataDefinitions[$alias];
        }
        if (isset($this->dataCalculations[$alias])) {
            return $this->dataCalculations[$alias];
        }
        if (isset($this->variableDefinitions[$alias])) {
            return $this->variableDefinitions[$alias];
        }
        */
    }

    protected function getUniqueAlias(string $name): string
    {
        while (isset($this->data[$name])) {
            $name = $this->makeNextName($name);
        }

        return $name;
    }

    protected function makeNextName(string $name): string
    {
        if (preg_match('/^(.+__)(\d+)$/', $name, $match)) {
            return $match[1] . ((int) $match[2] + 1);
        } else {
            return $name . '__2';
        }
    }

    /**
     * @return string[]
     */
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
