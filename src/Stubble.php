<?php

namespace Lukeraymonddowning\Stubble;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Stubble
{
    public static $tags = ['{{', '}}'];

    /**
     * Specify the opening and closing tags that surround stub replacement values.
     *
     * @return void
     */
    public static function defineTags(string $openingTag, string $closingTag)
    {
        static::$tags = [$openingTag, $closingTag];
    }

    /**
     * Retrieve the contents of the given file and replace the content with the given values.
     *
     * @param Enumerable|array $values
     * @return string
     */
    public static function file(string $path, $values)
    {
        return (new static())->replace(File::get($path), $values);
    }

    /**
     * Safely copy a file to a new path, replacing the content with the given values.
     *
     * @param Enumerable|array $values
     * @return bool
     */
    public static function publish(string $stubPath, string $destinationPath, $values)
    {
        File::ensureDirectoryExists(Str::beforeLast($destinationPath, '/'));
        return File::put($destinationPath, static::file($stubPath, $values));
    }

    /**
     * Replace the content with the provided values.
     *
     * @return string
     */
    public function replace(string $content, $values)
    {
        $values = Collection::wrap($values);

        return $this->findReplaceableValues($content)
            ->reduce(
                fn ($content, $pendingReplacement) => $content->replace(
                    $pendingReplacement->raw(),
                    $pendingReplacement->modify($values->first(fn ($value, $key) => $pendingReplacement->matches($key)))
                ),
                Str::of($content)
            )
            ->__toString();
    }

    /**
     * Return all replaceable values found in the given content.
     *
     * @return Collection
     */
    public function findReplaceableValues(string $content)
    {
        $matches = [];
        $openingTag = static::$tags[0];
        $closingTag = static::$tags[1];

        preg_match_all("/$openingTag(.+?)$closingTag/", $content, $matches);

        return collect($matches[0])
            ->zip($matches[1])
            ->map(fn ($matchSet) => [$matchSet[0], Str::of($matchSet[1])->remove(' ')->explode('|')])
            ->map(fn ($match) => new PendingReplacement($match[0], ...$match[1]));
    }
}
