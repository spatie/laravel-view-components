<?php

namespace Spatie\ViewComponents;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class ViewComponentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('render', function ($expression) {
            $expressionParts = explode(',', $expression, 2);

            $componentClass = $this->findComponentClass($expressionParts[0]);
            $props = $expressionParts[1] ?? '[]';

            return "<?php echo app()->make({$componentClass}::class, {$props})->toHtml(); ?>";
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/view-components.php', 'view-components');
    }

    protected function findComponentClass(string $identifier): string
    {
        $identifier = trim($identifier, '\'" ');
        $identifier = str_replace('::class', '', $identifier);

        $componentClass = class_exists($identifier)
            ? $identifier
            : $this->expandComponentClassPath($identifier);

        if (!class_exists($componentClass)) {
            throw new InvalidArgumentException("View component [{$componentClass}]  not found.");
        }

        if ($componentClass instanceof Htmlable) {
            throw new InvalidArgumentException(
                "View component [{$componentClass}] must implement Illuminate\Support\Htmlable."
            );
        }

        return $componentClass;
    }

    protected function expandComponentClassPath(string $path): string
    {
        $defaultNamespace = $this->app->config->get('view-components.default_namespace');

        return collect(explode('.', $path))
            ->map(function (string $part) {
                return ucfirst($part);
            })
            ->prepend($defaultNamespace)
            ->implode('\\');
    }
}
