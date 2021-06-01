<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * @dataProvider viewDataProvider
     */
    public function test_it_converts_replaced_values_to_view_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function viewDataProvider()
    {
        return [
            ['{{ value | view }}', ['value' => 'SomeClassName\\HelloWorld\\Welcome'], 'some-class-name.hello-world.welcome'],
            ['{{ value | view }}', ['value' => 'Some Class Name'], 'some-class-name'],
            ['{{ value | view }}', ['value' => 'some_class_name.test'], 'some_class_name.test'],
        ];
    }
}
