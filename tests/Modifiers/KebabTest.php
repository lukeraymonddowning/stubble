<?php


namespace Lukeraymonddowning\Stubble\Tests\Modifiers;


use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class KebabTest extends TestCase
{

    /**
     * @dataProvider kebabDataProvider
     */
    public function test_it_converts_replaced_values_to_kebab_case($content, $values, $expectation)
    {
        $content = (new Stubble)->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function kebabDataProvider()
    {
        return [
            ['Hello {{ world | kebab }}', ['world' => 'to the world'], 'Hello to-the-world'],
            ['{{class|kebab}} extends BaseClass', ['class' => 'some factory'], 'some-factory extends BaseClass'],
            ['{{kebab|kebab}} extends BaseClass', ['kebab' => 'CoolBeans'], 'cool-beans extends BaseClass'],
        ];
    }

}
