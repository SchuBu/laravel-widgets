# Laravel Widget Package - keep your controllers clean and DRY

[![Latest Version on Packagist](https://img.shields.io/packagist/v/schubu/laravel-widgets.svg?style=flat-square)](https://packagist.org/packages/schubu/laravel-widgets)
[![Build Status](https://img.shields.io/travis/schubu/laravel-widgets/master.svg?style=flat-square)](https://travis-ci.org/schubu/laravel-widgets)
[![Quality Score](https://img.shields.io/scrutinizer/g/schubu/laravel-widgets.svg?style=flat-square)](https://scrutinizer-ci.com/g/schubu/laravel-widgets)
[![Total Downloads](https://img.shields.io/packagist/dt/schubu/laravel-widgets.svg?style=flat-square)](https://packagist.org/packages/schubu/laravel-widgets)

A laravel widget package based on [the laracasts episode](https://laracasts.com/series/building-laracasts/episodes/2). It helps you to keep your
controller clean and DRY. 

## Installation

You can install the package via composer:

```bash
composer require schubu/laravel-widgets
```

## Usage

### Artisan command

You can create a widget by running this artisan command:
``` bash
php artisan make:widget ExampleWidget
```

It will two folders: 
 - a ```Widget``` folder within the ```app/Http``` directory
 - a ```widget``` folder within the ```resource/views``` directory
 
 This task also places a class file and a blade file to get started.
 - ```app/Http/ExampleWidget.php```
 - ```resource/views/example-widget.blade.php```
 
### Blade @widget directive

You can easily include your widget by using this blade directive:

```@widget('ExampleWidget')'``` 

### Passing data to your widget

You can pass data in two ways:
 - define a public property
 - define a public method
 
The public methods and properties will be passed as variables to your blade view!
 
#### Example
Your class: 
``` php
namespace App\Http\Widgets;

use SchuBu\LaravelWidgets\LaravelWidgets;

class ExampleWidget extends LaravelWidgets
{
    public $exampleData = "Welcome to your widget!";

    public function exampleMethod()
    {
        return [
            "My first data",
            "My second data",
            "My third data"
        ];
    }
}
```

In your blade you can access your data this way: 
``` html
This is {{ $exampleData }} awesome!
@foreach($exampleMethod as $content)
    {{ $content }} <br>
@endforeach
```

### Specifying the blade filename
You can customize the blade filename by adding an additional parameter to the artisan command:
``` bash
php artisan make:widget ExampleWidget MyExampleWidget
```

That results in a blade file named ```my-example-widget.blade.php```. The generated class now contains an additional protected 
property ```$viewPath```


``` php
namespace App\Http\Widgets;

use SchuBu\LaravelWidgets\LaravelWidgets;

class ExampleWidget extends LaravelWidgets
{
  protected $viewPath = 'widgets.my-example-widget';
  ...
}
```

### Testing

Because I'm new to testing, no testing at all happened :-(.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

This is my first package ever. So hope you'll contribute and help improving it. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email peter@schu-bu.de instead of using the issue tracker.

## Credits

- [Peter Schulze-Buxloh](https://github.com/schubu)
- [Jeffrey Way](https://gist.github.com/JeffreyWay)
- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
