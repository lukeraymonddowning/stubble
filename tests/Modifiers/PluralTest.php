<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class PluralTest extends TestCase
{
    /**
     * @dataProvider pluralDataProvider
     */
    public function test_it_converts_replaced_values_to_plural_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function pluralDataProvider()
    {
        return [
            ['Hello {{ world | plural }}', ['world' => 'to the world'], 'Hello to the worlds'],
            ['{{class|plural}} extends BaseClass', ['class' => 'some factory'], 'some factories extends BaseClass'],
            ['{{plural|plural}} extends BaseClass', ['plural' => 'CoolBean'], 'CoolBeans extends BaseClass'],
            ['{{plural|plural|camel}} extends BaseClass', ['plural' => 'CoolBean'], 'coolBeans extends BaseClass'],
        ];
    }
}
