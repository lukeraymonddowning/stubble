<?php


namespace Lukeraymonddowning\Stubble\Tests;


use Lukeraymonddowning\Stubble\PendingReplacement;
use Lukeraymonddowning\Stubble\Stubble;

class TagTest extends TestCase
{

    /**
     * @dataProvider tagDataProvider
     */
    public function test_it_can_define_tags($openingTag, $closingTag, $content, $expectation)
    {
        Stubble::defineTags($openingTag, $closingTag);
        $replacements = (new Stubble)->findReplaceableValues($content);
        expect($replacements)->toEqual(collect($expectation));
    }

    public function tagDataProvider()
    {
        return [
            [
                '{{',
                '}}',
                "Hello {{ world }}, my name is {{ name }}",
                [
                    new PendingReplacement('{{ world }}', 'world'),
                    new PendingReplacement('{{ name }}', 'name')
                ]
            ],
            [
                '{{',
                '}}',
                "Hello {{ world | studly }}, my name is {{ name | camel }}",
                [
                    new PendingReplacement('{{ world | studly }}', 'world', 'studly'),
                    new PendingReplacement('{{ name | camel }}', 'name', 'camel')
                ]
            ],
            [
                '--',
                '--',
                "Hello {{ world | studly }}, my --name-- is {{ John | camel }}",
                [new PendingReplacement('--name--', 'name')]
            ],
            [
                '--',
                '}}',
                "Hello {{ world | studly }}, my --name-- is {{ John | camel }}",
                [new PendingReplacement('--name-- is {{ John | camel }}', 'name--is{{John', 'camel')]
            ]
        ];
    }

}
