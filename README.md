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
        return view({{ view }});
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
        return view({{ class | kebab }});
    }

}
```

Note that we no longer have to reference 2 different variables. Instead, we add a *modifier* to the variable which 
describes how it should be transformed before being replaced. 

Now, in our Artisan command, we can use the `pipe` method to easily publish our stub to the user's application:

```php
public function handle() {
    Stubble::publish('path/to/your/stub.php', app_path('Some/Directory/File.php'), ['class' => $this->argument('name')]);
}
```

Stubble will take care of copying the file, performing the necessary content transformations, and publishing it to the
new location.


