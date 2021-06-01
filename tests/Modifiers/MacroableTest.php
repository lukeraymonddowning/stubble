<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Modifier;
use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;
use Str;

class MacroableTest extends TestCase
{
    public function test_a_macro_can_be_called()
    {
        Modifier::macro('vowelless', function ($content) {
            return Str::of($content)->remove(['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'])->__toString();
        });

        $result = (new Stubble())->replace('{{ test | vowelless }}', ['test' => 'Hello World']);

        expect($result)->toEqual('Hll Wrld');
    }
}
