<?php


namespace Lukeraymonddowning\Stubble\Tests\Modifiers;


use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class UpperTest extends TestCase
{

    /**
     * @dataProvider upperDataProvider
     */
    public function test_it_converts_replaced_values_to_upper_case($content, $values, $expectation)
    {
        $content = (new Stubble)->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function upperDataProvider()
    {
        return [
            ['Hello {{ world | upper }}', ['world' => 'to the world'], 'Hello TO THE WORLD'],
            ['{{class|upper}} extends BaseClass', ['class' => 'some factory'], 'SOME FACTORY extends BaseClass'],
            ['{{upper|upper}} extends BaseClass', ['upper' => 'CoolBeans'], 'COOLBEANS extends BaseClass'],
        ];
    }

}
