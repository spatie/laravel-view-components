<?php

namespace Spatie\ViewComponents;

use Illuminate\Contracts\Support\Htmlable;
use InvalidArgumentException;

final class CompileRenderDirective
{
    /** @var \Spatie\ViewComponents\ComponentFinder */
    private $componentFinder;

    public function __construct(ComponentFinder $componentFinder)
    {
        $this->componentFinder = $componentFinder;
    }

    public function __invoke(string $expression): string
    {
        $expressionParts = explode(',', $expression, 2);

        $componentClass = $this->componentFinder->find($expressionParts[0]);

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
    }
}
