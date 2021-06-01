<?php

namespace Lukeraymonddowning\Stubble;

class PendingReplacement
{
    protected string $raw;
    protected string $key;
    protected array $modifiers = [];

    public function __construct(string $raw, string $key, ...$modifiers)
    {
        $this->raw = $raw;
        $this->key = $key;
        $this->modifiers = $modifiers;
    }

    public function raw()
    {
        return $this->raw;
    }

    public function matches($key)
    {
        return $key == $this->key;
    }

    public function modify($value)
    {
        $modifier = new Modifier();

        return collect($this->modifiers)->reduce(fn ($value, $mod) => $modifier->$mod($value), $value);
    }
}
