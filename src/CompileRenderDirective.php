<?php

namespace Spatie\ViewComponents;

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

        $componentPath = $expressionParts[0];
        $props = trim($expressionParts[1] ?? '[]');

        return "<?php echo app(app(Spatie\ViewComponents\ComponentFinder::class)->find({$componentPath}), ".
            "{$props})->toHtml(); ?>";
    }
}
