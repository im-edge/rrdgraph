<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\Render;

/**
 * The dashes modifier enables dashed line style. Without any further
 * options a symmetric dashed line with a segment length of 5 pixels will
 * be drawn.
 */
trait Dashes
{
    protected ?string $dashes = null;
    protected ?string $dashOffset = null;

    public function getDashes(): ?string
    {
        return $this->dashes;
    }

    /**
     * The dash pattern can be changed if the dashes= parameter is followed by
     * either one value or an even number (1, 2, 4, 6, ...) of positive values.
     * Each value provides the length of alternate on_s and off_s portions of
     * the stroke.
     */
    public function setDashes(?string $dashes): self
    {
        $this->dashes = $dashes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDashOffset(): ?string
    {
        return $this->dashOffset;
    }

    /**
     * The dash-offset parameter specifies an offset into the pattern at which
     * the stroke begins.
     *
     * @param string|null $dashOffset
     * @return $this
     */
    public function setDashOffset(?string $dashOffset): self
    {
        $this->dashOffset = $dashOffset;
        return $this;
    }

    protected function renderDashProperties(): string
    {
        return Render::optionalNamedParameter('dashes', $this->getDashes())
            . Render::optionalNamedParameter('dash-offset', $this->getDashOffset());
    }
}
