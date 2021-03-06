<?php

namespace Lukeraymonddowning\Stubble\Tests;

use Illuminate\Support\Facades\File;
use Lukeraymonddowning\Stubble\Stubble;

class StubFileTest extends \Orchestra\Testbench\TestCase
{
    public function test_it_can_return_a_stubbed_file()
    {
        File::shouldReceive('get')
            ->andReturn('{{ greetings | studly }}, most honoured guest!');

        $content = Stubble::file('example/file.php', ['greetings' => 'hello world']);

        expect($content)->toEqual('HelloWorld, most honoured guest!');
    }

    public function test_it_can_pipe_a_file_to_a_new_location()
    {
        File::shouldReceive('get')
            ->once()
            ->andReturn('{{ greetings | studly }}, most honoured guest!')
            ->shouldReceive('ensureDirectoryExists')
            ->once()
            ->with('an/example')
            ->andReturnTrue()
            ->shouldReceive('put')
            ->once()
            ->with('an/example/file.php', 'HelloWorld, most honoured guest!')
            ->andReturnTrue();

        Stubble::publish('example/file.php', 'an/example/file.php', ['greetings' => 'hello world']);
    }

    public function test_it_replaces_tags_in_the_destination_file_name()
    {
        File::shouldReceive('get')
            ->once()
            ->andReturn('{{ greetings | studly }}, most honoured guest!')
            ->shouldReceive('ensureDirectoryExists')
            ->once()
            ->with('An/Example')
            ->andReturnTrue()
            ->shouldReceive('put')
            ->once()
            ->with('An/Example/file.php', 'HelloWorld, most honoured guest!')
            ->andReturnTrue();

        Stubble::publish(
            'example/file.php',
            'An/{{ class | basename }}/file.php',
            ['class' => 'Cool/Example', 'greetings' => 'hello world']
        );
    }
}
