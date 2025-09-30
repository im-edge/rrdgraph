<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph;

use InvalidArgumentException;

use function ltrim;
use function strlen;
use function substr;

class Color
{
    protected ?string $hexCode = null;
    protected ?string $alpha = null;

    /**
     * @param string|Color|null $hexCode
     * @param string|Color|null $alpha
     */
    public function __construct($hexCode = null, $alpha = null)
    {
        if ($hexCode === null) {
            return;
        }

        if ($hexCode instanceof Color) {
            $this->hexCode = $hexCode->getHexCode();
            $this->alpha = $hexCode->getAlphaHex();
        } else {
            $hexCode = ltrim($hexCode, '#');
            if (strlen($hexCode) === 6) {
                $this->hexCode = $hexCode;
            } elseif (strlen($hexCode) === 8) {
                $this->hexCode = substr($hexCode, 0, 6);
                $this->alpha = substr($hexCode, 6);
            } else {
                throw new InvalidArgumentException("Valid color hex code expected, got $hexCode");
            }
        }

        if ($alpha !== null) {
            $this->setAlphaHex((string) $alpha);
        }
    }

    public function getHexCode(): ?string
    {
        return $this->hexCode;
    }

    public function setAlphaHex(string $alpha): self
    {
        $this->alpha = $alpha;

        return $this;
    }

    public function getAlphaHex(): ?string
    {
        return $this->alpha;
    }

    public function isNull(): bool
    {
        return $this->hexCode === null;
    }

    public function toRgba(): ?string
    {
        if ($this->hexCode === null) {
            return null;
        }

        return sprintf(
            'rgba(%d, %d, %d, %.3F)',
            hexdec(substr($this->hexCode, 0, 2)),
            hexdec(substr($this->hexCode, 2, 2)),
            hexdec(substr($this->hexCode, 4, 2)),
            $this->alpha === null ? 1 : (hexdec($this->alpha) / 255),
        );
    }

    /**
     * @param string|Color|null $color
     * @return Color
     */
    public static function create($color): Color
    {
        if ($color instanceof Color) {
            return clone($color);
        } else {
            return new Color($color);
        }
    }

    public function __toString()
    {
        if ($this->hexCode === null) {
            return '';
        }

        return '#' . $this->hexCode . ($this->alpha ?? '');
    }
}
