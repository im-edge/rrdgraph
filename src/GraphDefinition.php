<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph;

use IMEdge\RrdGraph\Data\Assignment;
use IMEdge\RrdGraph\Graph\Instruction\GraphInstructionInterface;
use IMEdge\RrdGraph\Graph\Instruction\InstructionWithVariableInterface;
use IMEdge\RrdGraph\Rpn\RpnExpression;
use InvalidArgumentException;
use RuntimeException;

class GraphDefinition
{
    /** @var array<string, array<string, Assignment>> */
    protected array $defs = [
        // Assignments with DataDefinition
        Assignment::TAG_DATA_DEFINITION => [],
        // Assignments with DataCalculation
        Assignment::TAG_DATA_CALCULATION => [],
        // Assignments with VariableDefinition
        Assignment::TAG_VARIABLE_DEFINITION => [],
    ];
    /** @var array<int, Assignment> */
    protected array $sortedDefs = [];

    /** @var array<string, string> $variableNames = $variableName => $tag */
    protected array $variableNames = [];

    /** @var GraphInstructionInterface[] */
    protected array $instructions = [];

    public function addAssignment(Assignment $assignment): void
    {
        $tag = $assignment->getTag();
        $name = $assignment->getVariableName()->getName();
        if (isset($this->variableNames[$name])) {
            $existingTag = $this->variableNames[$name];
            /** @var Assignment $current */
            $current = $this->defs[$existingTag][$name];
            throw  new RuntimeException(sprintf(
                'Cannot set variable name %s twice. Rejecting "%s", there is already "%s"',
                $name,
                $assignment,
                $current
            ));
        }
        $this->variableNames[$name] = $tag;
        $this->defs[$tag][$name] = $assignment;
        $this->sortedDefs[] = $assignment;
    }

    public function getAssignment(string $variableName): Assignment
    {
        if (! isset($this->variableNames[$variableName])) {
            throw new InvalidArgumentException("Got no such definition: '$variableName'");
        }

        $tag = $this->variableNames[$variableName];

        return $this->defs[$tag][$variableName];
    }

    public function addGraphInstruction(GraphInstructionInterface $instruction): void
    {
        $this->instructions[] = $instruction;
    }

    /**
     * @return string[]
     */
    public function listVariableNames(): array
    {
        return array_merge(
            array_keys($this->defs[Assignment::TAG_DATA_DEFINITION]),
            array_keys($this->defs[Assignment::TAG_DATA_CALCULATION]),
            array_keys($this->defs[Assignment::TAG_VARIABLE_DEFINITION]),
        );
    }

    /**
     * @return Assignment[]
     */
    public function getDefinitions(): array
    {
        return $this->defs[Assignment::TAG_DATA_DEFINITION]
            + $this->defs[Assignment::TAG_DATA_CALCULATION]
            + $this->defs[Assignment::TAG_VARIABLE_DEFINITION];
    }

    /**
     * @return Assignment[]
     */
    public function getDataDefinitions(): array
    {
        return $this->defs[Assignment::TAG_DATA_DEFINITION];
    }

    public function hasDataDefinitions(): bool
    {
        return !empty($this->defs[Assignment::TAG_DATA_DEFINITION]);
    }

    /**
     * @return Assignment[]
     */
    public function getDataCalculations(): array
    {
        return $this->defs[Assignment::TAG_DATA_CALCULATION];
    }

    public function hasDataCalculations(): bool
    {
        return !empty($this->defs[Assignment::TAG_DATA_CALCULATION]);
    }

    /**
     * @return Assignment[]
     */
    public function getVariableDefinitions(): array
    {
        return $this->defs[Assignment::TAG_VARIABLE_DEFINITION];
    }

    public function hasVariableDefinitions(): bool
    {
        return !empty($this->defs[Assignment::TAG_VARIABLE_DEFINITION]);
    }

    public function hasInstructions(): bool
    {
        return !empty($this->instructions);
    }

    /**
     * @return GraphInstructionInterface[]
     */
    public function getInstructions(): array
    {
        return $this->instructions;
    }

    /**
     * @param GraphInstructionInterface[] $instructions
     */
    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }


    /**
     * @return array<string, Assignment>
     */
    protected function getAllAssignments(): array
    {
        return array_merge(
            $this->defs[Assignment::TAG_DATA_DEFINITION],
            $this->defs[Assignment::TAG_DATA_CALCULATION],
            $this->defs[Assignment::TAG_VARIABLE_DEFINITION],
        );
    }

    /**
     * @return string[]
     */
    public function listMissingDefinitionNames(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function listUsedVariableNames(): array
    {
        return array_keys($this->variableNames);
    }

    public function renameVariable(string $oldName, string $newName): void
    {
        $assignment = $this->getAssignment($oldName);
        // Fix def name
        $assignment->getVariableName()->setName($newName);
        $tag = $assignment->getTag();
        $newDefs = [];
        // Reindex defs, respect former order
        foreach ($this->defs[$tag] as $key => $def) {
            if ($key === $oldName) {
                $newDefs[$newName] = $def;
            } else {
                $newDefs[$key] = $def;
            }
        }
        $this->defs[$tag] = $newDefs;
        unset($newDefs);

        foreach ($this->getDataCalculations() + $this->getVariableDefinitions() as $assignment) {
            $expression = $assignment->getExpression();
            assert($expression instanceof RpnExpression);
            $expression->renameVariable($oldName, $newName);
        }
        foreach ($this->instructions as $instruction) {
            if ($instruction instanceof InstructionWithVariableInterface) {
                $instruction->renameVariable($oldName, $newName);
            }
        }
    }

    public function __toString(): string
    {
        return implode(' ', array_merge($this->sortedDefs, $this->instructions));
    }
}
