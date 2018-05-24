<?php

namespace Spatie\ViewComponents;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class ViewComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('render', function ($expression) {
            $expressionParts = explode(',', $expression, 2);

            $componentClass = $this->app->make(ComponentFinder::class)->find($expressionParts[0]);

            if (!class_exists($componentClass)) {
                throw new InvalidArgumentException("View component [{$componentClass}] not found.");
            }

            if (!array_key_exists(Htmlable::class, class_implements($componentClass))) {
                throw new InvalidArgumentException(
                    "View component [{$componentClass}] must implement Illuminate\Support\Htmlable."
                );
            }

            $props = trim($expressionParts[1] ?? '[]');

            return "<?php echo app()->make({$componentClass}::class, {$props})->toHtml(); ?>";
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/view-components.php', 'view-components');

        $this->app->singleton(ComponentFinder::class, function () {
            return new DotPathComponentFinder(
                $this->app->config->get('view-components.root_namespace'),
                $this->app->config->get('view-components.namespaces')
            );
        });
    }
}
