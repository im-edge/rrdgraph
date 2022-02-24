<?php

namespace gipfl\RrdGraph;

use Generator;
use gipfl\RrdGraph\Data\DataDefinitionInterface;
use gipfl\RrdGraph\Data\DataDefinitionRegistry;
use gipfl\RrdGraph\Data\Def;
use RuntimeException;
use function preg_match;
use function strlen;
use function substr;

class GraphDefinitionParser
{
    const FIELD_SEPARATOR = ':';
    const STRING_ENCLOSURE = "'";
    const ESCAPE = '\\';
    protected string $string;
    protected int $position;
    protected int $length;

    public function __construct(string $string)
    {
        $this->string = $string;
        $this->position = 0;
        $this->length = strlen($string);
    }

    public function parse(): Generator
    {
        $limit = $this->length - 1;
        while ($this->position < $limit) {
            foreach ($this->parseDefinitions() as $res) {
                yield $res;
            }
        }
    }

    protected function parseDefinitions(): Generator
    {
        $this->skipWhitespace();
        $type = $this->readType();
        if (strlen($type) === 0) {
            throw new RuntimeException('Parser should never reach an empty type');
        }
        $parameters = [];
        foreach ($this->parseParameters() as $parameter) {
            $parameters[] = $parameter;
        }
        if (DataDefinitionRegistry::isKnown($type)) {
            /** @var string|DataDefinitionInterface $class */
            $class = DataDefinitionRegistry::getClass($type);
            $def = $class::fromParameters($parameters);
            yield $def;
        } else {
            var_dump($type);
            exit;
            yield [$type, $parameters];
        }
    }

    protected function readType(): string
    {
        $start = $this->position;
        $length = 1;
        while (self::FIELD_SEPARATOR !== ($current = $this->requireNextCharacter())) {
            if ($current === self::ESCAPE) {
                $this->requireNextCharacter();
                $length++;
            }

            $length++;
        }

        return substr($this->string, $start, $length);
    }

    protected function parseParameters(): Generator
    {
        $start = $this->position + 1;
        $length = 0;
        $stringContext = false;
        while (null !== ($current = $this->nextCharacter())) {
            $length++;
            if ($current === self::ESCAPE) {
                $this->requireNextCharacter();
                $length++;
                continue;
            }
            if ($current === self::STRING_ENCLOSURE) {
                $stringContext = !$stringContext;
            }
            // TODO: we support unescaped colons in a string, should check whether rrdtool also does so
            if (! $stringContext) {
                $next = $this->peek();
                if ($next === self::FIELD_SEPARATOR) {
                    $this->requireNextCharacter();
                    yield substr($this->string, $start, $length);
                    $start = $this->position + 1;
                    $length = 0;
                    continue;
                }
                if (preg_match('/[\r\n\s]/', $next)) {
                    $this->requireNextCharacter();
                    yield substr($this->string, $start, $length);
                    return;
                }
                if ($next === null) {
                    yield substr($this->string, $start, $length);
                    return;
                }
            }
        }

        if ($length > 0) {
            throw new RuntimeException('Parse error, caused by software bug');
        }
    }

    protected function requireNextCharacter(): string
    {
        $next = $this->nextCharacter();
        if ($next === null) {
            throw new RuntimeException("Reached unexpected end of string");
        }

        return $next;
    }

    protected function nextCharacter(): ?string
    {
        $next = $this->peek();
        $this->position++;
        if ($next === null) {
            return null;
        }

        return $next;
    }

    protected function peek(): ?string
    {
        $nextPos = $this->position + 1;
        if ($nextPos < $this->length) {
            return $this->string[$nextPos];
        }

        return null;
    }

    protected function skipWhitespace()
    {
        while ($this->position < $this->length
            && preg_match('/[\r\n\s\t]/', $this->string[$this->position])
        ) {
            $this->position++;
        }
    }
}
