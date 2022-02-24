<?php

namespace gipfl\RrdGraph;

use InvalidArgumentException;
use function ltrim;
use function strlen;
use function substr;

class Color
{
    protected ?string $hexCode = null;
    protected ?string $alpha = null;

    public function __construct($hexCode, $alpha = null)
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
            $this->setAlphaHex($alpha);
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

    /**
     * @param $color
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
        if ($this->isNull()) {
            return '';
        }

        return '#' . $this->hexCode . ($this->alpha ?? '');
    }
}
