# Stubble

A simple templating language for .stub files in Laravel projects and packages.

## What is Stubble for?

If you've ever built a package for Laravel, you've likely also created little `.stub` files that are published to the
user's project when they run a certain command. Often, these stubs will feature dynamic content that is filled based on
user input. For example, you may need to fill out a class name, or a namespace, or a filename based on the argument
passed in to an Artisan command. 

Usually, the *actual value* of the dynamic content is the same, but the *format* may need to change depending on its 
location; a filename might need to be kebab-cased, but a class name should be PascalCase. It's annoying to have to
redefine all of these simple transformations to the same value just to publish a stub. What if there was a way to 
define these transformations *inside* the stub file? That's exactly what Stubble allows you to do.

## Installation

You can install Stubble via Composer:

```bash
composer require lukeraymonddowning/stubble
```

## Usage

Imagine you're writing an Artisan command that publishes 2 files: a class and a blade view. The class references the 
blade view, but we don't want the user to have to specify the name of both; the blade view filename should be automatically
determined by the name of the class. Let's imagine the command looks like this:

```bash
php artisan make:magic MyDesiredClassName
```

You have a stub file for the class that might look like this:

```php
// class.php.stub

<?php

class {{ class }} extends Component {

    public function render() {
        return view('{{ view }}');
    }

}
```

Here we have to create 2 replacement values: "class" and "view", but the fact of the matter is that the name of the view
*is* the name of the class, just formatted in kebab-case rather than PascalCase. Let's rewrite our stub using stubble:

```php
// class.php.stub

<?php

class {{ class | pascal }} extends Component {

    public function render() {
        return view('{{ class | kebab }}');
    }

}
```

Note that we no longer have to reference 2 different variables. Instead, we add a *modifier* to the variable which 
describes how it should be transformed before being replaced. 

Now, in our Artisan command, we can use the `publish` method to easily publish our stub to the user's application:

```php
public function handle() {
    Stubble::publish('path/to/your/stub.php', app_path('Some/Directory/File.php'), ['class' => $this->argument('name')]);
}
```

Stubble will take care of copying the file, performing the necessary content transformations, and publishing it to the
new location.

## Available Modifiers

Modifiers are the key to transforming content inside of your stub files. You can separate multiple modifiers with the
pipe `|` character.

### basename

The `basename` modifier will return the basename of a given class string:

```php
// class: Some\Deeply\Nested\Thing
class {{ class | basename }} {} // class Thing {}
```

### camel

The `camel` modifier transforms the given value to camelCase.

### classname

The `classname` modifier transforms a string to its fully qualified class name if possible:

```php
// class: Some/Class/With/Forward/Slashes
use {{ class | classname }} // Some\Class\With\Forward\Slashes

// view: some-nested.view
use {{ view | classname }} // SomeNested\View
```

### kebab

The `kebab` modifier transforms the given value to kebab-case.

### lower

The `lower` modifier transforms the given value to lowercase.

### plural

The `plural` modifier transforms the given value to the plural version. For example, 'duck' would become 'ducks'.

### singular

The `singular` modifier transforms the given value to the singular version. For example, 'ducks' would become 'duck'.

### snake

The `snake` modifier transforms the given value to snake_case.

### studly

The `studly` modifier transforms the given value to StudlyCase.

### upper

The `upper` modifier transforms the given value to UPPERCASE.

### view

The `view` modifier transforms a class string to a valid view destination:

```php
// class: Some\ProjectClass

return view('{{ class | view }}'); // some.project-class
```

## Chaining multiple Modifiers

Modifiers can be chained together to perform multiple transformations. They will be applied in order from left to right.
Modifiers are separated using the `|` character:

```php
// .stub
Welcome to the {{ jungle | upper | plural }}! // Welcome to the JUNGLES!
```

## Adding new Modifiers

The `Lukeraymonddowning\Stubble\Modifier` class is `Macroable`, allowing you to define your very own modifiers. We 
suggest you do this in the `boot` method of your `ServiceProvider`. Each modifier should return a modified string
value.

```php
// ServiceProvider
Modifier::macro('vowelless', function ($content) {
    return Str::of($content)->remove(['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'])->__toString();
});

// .stub
Hello {{ example | vowelless }} // All vowels will be removed from the value of 'example'
```

## Replacing a file's contents without publishing

If you want to perform tag transformations on a file, but return it as a string to perform extra work on it, you can
use the `file` method:

```php
$content = Stubble::file('path/to/your/stub.php.stub', ['key' => 'value']);
```

## Converting values outside of stub files

Sometimes, you may want to use the power of Stubble outside of stub files, perhaps for the filename of a given stub.
You can do that using the replace method:

```php
$filename = (new Stubble)->replace("path/to/your/{{ file | kebab }}.php", ['file' => $this->argument('name')]);
```

> Tip! When using the `publish` method, you can use tags directly in the $destinationPath argument for no sweat 
> dynamic filenames.

```php
Stubble::publish(
    'path/to/stub.php',
    'Path/To/Your/{{ class | basename }}.php',
    ['class' => $this->argument('class')]
);
```

## Customising stub tags

By default, Stubble will use `{{` and `}}` as the start and end of tags respectively. You are free to customise these
locators using the `defineTags` method:

```php
Stubble::defineTags('--', '--'); // Use -- as the tag locators
Stubble::defineTags('{{', '--'); // Use {{ as the starting locator and -- as the ending locator
```
