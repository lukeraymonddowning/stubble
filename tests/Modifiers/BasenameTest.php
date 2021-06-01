<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class BasenameTest extends TestCase
{
    /**
     * @dataProvider basenameDataProvider
     */
    public function test_it_converts_replaced_values_to_basename_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function basenameDataProvider()
    {
        return [
            ['class {{ class | basename }} {}', ['class' => 'Some\\Deeply\\Nested\\Thing'], 'class Thing {}'],
            ['class {{ class | basename }} {}', ['class' => 'random value'], 'class random value {}'],
        ];
    }
}
