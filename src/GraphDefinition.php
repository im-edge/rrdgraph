<?php declare(strict_types=1);

namespace gipfl\RrdGraph;

use gipfl\RrdGraph\Data\Assignment;
use gipfl\RrdGraph\Graph\Instruction\GraphInstructionInterface;
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

    /** @var array<string, string> $variableNames = $variableName => $tag */
    protected array $variableNames = [];

    /** @var GraphInstructionInterface[] */
    protected array $instructions = [];

    public function addAssignment(Assignment $assignment)
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
    }

    public function addGraphInstruction(GraphInstructionInterface $instruction)
    {
        $this->instructions[] = $instruction;
    }

    public function listVariableNames(): array
    {
        return array_merge(
            array_keys($this->defs[Assignment::TAG_DATA_DEFINITION]),
            array_keys($this->defs[Assignment::TAG_DATA_CALCULATION]),
            array_keys($this->defs[Assignment::TAG_VARIABLE_DEFINITION]),
        );
    }

    protected function getAllAssignments(): array
    {
        return array_merge(
            $this->defs[Assignment::TAG_DATA_DEFINITION],
            $this->defs[Assignment::TAG_DATA_CALCULATION],
            $this->defs[Assignment::TAG_VARIABLE_DEFINITION],
        );
    }

    public function listMissingDefinitionNames(): array
    {
        return [];
    }

    public function __toString(): string
    {
        return implode(' ', array_merge($this->getAllAssignments(), $this->instructions));
    }
}
