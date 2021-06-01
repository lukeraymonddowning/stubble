<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class SnakeTest extends TestCase
{
    /**
     * @dataProvider snakeDataProvider
     */
    public function test_it_converts_replaced_values_to_snake_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function snakeDataProvider()
    {
        return [
            ['Hello {{ world | snake }}', ['world' => 'to the world'], 'Hello to_the_world'],
            ['{{class|snake}} extends BaseClass', ['class' => 'some factory'], 'some_factory extends BaseClass'],
            ['{{snake|snake}} extends BaseClass', ['snake' => 'CoolBeans'], 'cool_beans extends BaseClass'],
        ];
    }
}
