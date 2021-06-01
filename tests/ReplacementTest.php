<?php

namespace Lukeraymonddowning\Stubble\Tests;

use Lukeraymonddowning\Stubble\Stubble;

class ReplacementTest extends TestCase
{
    /**
     * @dataProvider replacementDataProvider
     */
    public function test_it_replaces_the_replaceable_values($content, $values, $expectations)
    {
        $content = (new Stubble())->replace($content, $values);
        expect($content)->toEqual($expectations);
    }

    public function replacementDataProvider()
    {
        return [
            ['{{ hello }} World!', ['hello' => 'Hi'], 'Hi World!'],
            ['{{ class }} extends AnotherClass', ['class' => 'MyClass'], 'MyClass extends AnotherClass'],
            ['{{ class }} extends {{ class }}', ['class' => 'MyClass'], 'MyClass extends MyClass'],
            ['{{ class }} extends {{ class }} implements {{ otherClass }}', ['class' => 'MyClass', 'otherClass' => 'OtherClass'], 'MyClass extends MyClass implements OtherClass'],
        ];
    }
}
