# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-view-components.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-components)
[![Build Status](https://img.shields.io/travis/spatie/laravel-view-components/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-view-components)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-view-components.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-view-components)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-view-components.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-components)

View components are a way to help organize logic tied to view, similar to [view composers](https://laravel.com/docs/5.6/views#view-composers).

```php
namespace App\Http\ViewComponents;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Htmlable;

class NavigationComponent implements Htmlable
{
    /** \Illuminate\Http\Request */
    private $request;

    /** @var string */
    private $backgroundColor;

    public function __construct(Request $request, string $backgroundColor)
    {
        $this->request = $request;
        $this->backgroundColor = $backgroundColor;
    }

    public function toHtml(): string
    {
        return view('components.navigation', [
            'activeUrl' => $this->request->url(),
            'backgroundColor' => $this->backgroundColor,
        ]);
    }
}
```

```blade
@render('navigation', ['backgroundColor' => 'black'])
```

A view component can be anything that implements Laravel's `Htmlable` contract, so you don't necessarily need to use Blade views to render the component. This is useful for wrapping third party HTML packages, like [spatie/laravel-menu](https://github.com/spatie/laravel-menu).

```php
namespace App\Http\ViewComponents;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Auth\Guard;
use Spatie\Menu\Laravel\Menu;

class MainMenuComponent implements Htmlable
{
    /** @var \Illuminate\Contracts\Auth\Guard */
    private $guard;

    /** @var string */
    private $class;

    public function __construct(Guard $guard, string $class = null)
    {
        $this->guard = $guard;
        $this->class = $class;
    }

    public function toHtml(): string
    {
        $menu = Menu::new()
            ->addClass($this->class)
            ->url('/', 'Home')
            ->url('/projects', 'Projects');

        if ($this->guard->check()) {
            $menu->url('/admin', 'Adminland');
        }

        return $menu;
    }
}
```

```blade
@render('mainMenu', ['class' => 'background-green'])
```

The benefit over view composers is that data and rendering logic are explicitly tied together in components instead of being connected afterwards. They also allow you to seamlessly combine properties and dependency injection.

This package is based on *[Introducing View Components in Laravel, an alternative to View Composerss](https://laravel-news.com/introducing-view-components-on-laravel-an-alternative-to-view-composers)* by [Jeff Ochoa](https://twitter.com/@Jeffer_8a).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-view-components
```

## Usage

``` php
$skeleton = new Spatie\Skeleton();
echo $skeleton->echoPhrase('Hello, Spatie!');
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
