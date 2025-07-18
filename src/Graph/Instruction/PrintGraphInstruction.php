<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\Data\VariableName;
use IMEdge\RrdGraph\DataType\BooleanType;
use IMEdge\RrdGraph\DataType\StringType;

/**
 * man rrdgraph_graph
 * ------------------
 * Depending on the context, either the value component (no suffix, valstrftime
 * or valstrfduration) or the time component (strftime) of a VDEF is printed
 * using format. It is an error to specify a vname generated by a DEF or CDEF.
 *
 * Any text in format is printed literally with one exception: The percent
 * character introduces a formatter string. This string can be: [see manpage]
 *
 * If you PRINT a VDEF value, you can also print the time associated with it by
 * appending the string :strftime to the format. Note that RRDtool uses the
 * strftime function of your OSs C library. This means that the conversion
 * specifier may vary. Check the manual page if you are uncertain. The following
 * is a list of conversion specifiers usually supported across the board.
 *
 * Formatting values interpreted as timestamps with :valstrftime is done
 * likewise.
 *
 * Synopsis
 * --------
 * PRINT:vname:format[:strftime|:valstrftime|:valstrfduration]
 */
class PrintGraphInstruction implements GraphInstructionInterface, InstructionWithVariableInterface
{
    public const TAG = 'PRINT';

    protected VariableName $variableName;
    protected StringType $format;
    protected ?BooleanType $strftime = null;
    protected ?BooleanType $valstrftime = null;
    protected ?BooleanType $valstrfduration = null;

    // TODO: [:strftime|:valstrftime|:valstrfduration]
    final public function __construct(VariableName $variableName, StringType $format)
    {
        $this->variableName = $variableName;
        $this->format = $format;
    }

    public function getVariableName(): VariableName
    {
        return $this->variableName;
    }

    public function renameVariable(string $oldName, string $newName): void
    {
        if ($this->variableName->getName() === $oldName) {
            $this->variableName->setName($newName);
        }
    }

    public function getFormat(): StringType
    {
        return $this->format;
    }

    public function isStrftime(): bool
    {
        return $this->strftime && $this->strftime->isTrue() === true;
    }

    public function setStrftime(?BooleanType $strftime): self
    {
        $this->strftime = $strftime;
        return $this;
    }

    public function isValstrftime(): bool
    {
        return $this->valstrftime && $this->valstrftime->isTrue();
    }

    public function setValstrftime(?BooleanType $valstrftime): self
    {
        $this->valstrftime = $valstrftime;
        return $this;
    }

    public function isValstrfduration(): bool
    {
        return $this->valstrfduration && $this->valstrfduration->isTrue();
    }

    public function setValstrfduration(?BooleanType $valstrfduration): self
    {
        $this->valstrfduration = $valstrfduration;
        return $this;
    }

    public function __toString(): string
    {
        return static::TAG
            . ':'
            . $this->getVariableName()
            . ':'
            . $this->getFormat()
            // TODO: add a list of unnamed booleans. Means that former ones must be empty::

            // NOPE: this is not correct, it is only one of those flags
            ;
    }

    public static function fromParameters(array $parameters): PrintGraphInstruction
    {
        // TODO: Set optional flags. We need a better abstraction for this
        return new static(
            new VariableName(array_shift($parameters) ?? ''),
            StringType::parse(array_shift($parameters) ?? '')
        );
    }
}
