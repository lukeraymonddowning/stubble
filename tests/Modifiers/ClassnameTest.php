<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class ClassnameTest extends TestCase
{
    /**
     * @dataProvider classDataProvider
     */
    public function test_it_converts_replaced_values_to_class_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function classDataProvider()
    {
        return [
            ['{{ value | classname }}', ['value' => 'a-view-file.nested-somewhere'], 'AViewFile\\NestedSomewhere'],
            ['{{ value | classname }}', ['value' => 'AViewFile\\NestedSomewhere'], 'AViewFile\\NestedSomewhere'],
            ['{{ value | classname }}', ['value' => 'AViewFile/NestedSomewhere'], 'AViewFile\\NestedSomewhere'],
            ['{{ value | classname }}', ['value' => 'A view file nested somewhere'], 'AViewFileNestedSomewhere'],
        ];
    }
}
