<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class LowerTest extends TestCase
{
    /**
     * @dataProvider lowerDataProvider
     */
    public function test_it_converts_replaced_values_to_lower_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function lowerDataProvider()
    {
        return [
            ['Hello {{ world | lower }}', ['world' => 'to the world'], 'Hello to the world'],
            ['{{class|lower}} extends BaseClass', ['class' => 'some factory'], 'some factory extends BaseClass'],
            ['{{lower|lower}} extends BaseClass', ['lower' => 'CoolBeans'], 'coolbeans extends BaseClass'],
        ];
    }
}
