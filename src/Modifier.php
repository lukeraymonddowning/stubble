<?php

namespace Lukeraymonddowning\Stubble;

use Illuminate\Support\Traits\Macroable;
use Str;

class Modifier
{
    use Macroable;

    public function studly($content)
    {
        return Str::studly($content);
    }

    public function snake($content)
    {
        return Str::snake($content);
    }

    public function camel($content)
    {
        return Str::camel($content);
    }

    public function kebab($content)
    {
        return Str::kebab($content);
    }

    public function upper($content)
    {
        return Str::upper($content);
    }

    public function lower($content)
    {
        return Str::lower($content);
    }

    public function plural($content)
    {
        return Str::plural($content);
    }

    public function singular($content)
    {
        return Str::singular($content);
    }

    public function view($content)
    {
        return Str::of($content)
            ->replace(['\\', '/'], '.')
            ->kebab()
            ->replace('.-', '.')
            ->__toString();
    }
}
