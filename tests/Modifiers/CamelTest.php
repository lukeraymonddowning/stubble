<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class CamelTest extends TestCase
{
    /**
     * @dataProvider camelDataProvider
     */
    public function test_it_converts_replaced_values_to_camel_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function camelDataProvider()
    {
        return [
            ['Hello {{ world | camel }}', ['world' => 'to the world'], 'Hello toTheWorld'],
            ['{{class|camel}} extends BaseClass', ['class' => 'some factory'], 'someFactory extends BaseClass'],
            ['{{camel|camel}} extends BaseClass', ['camel' => 'CoolBeans'], 'coolBeans extends BaseClass'],
        ];
    }
}
