<?php

namespace Spatie\ViewComponents\Tests;

class ClassNameTest extends TestCase
{
    /** @test */
    public function it_renders_a_component_from_a_classname()
    {
        $this->assertBladeCompilesTo(
            '<?php echo app(app(Spatie\ViewComponents\ComponentFinder::class)->find(Spatie\ViewComponents\Tests\Stubs\MyComponent::class), [])->toHtml(); ?>',
            '@render(Spatie\ViewComponents\Tests\Stubs\MyComponent::class)'
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_classname_with_props()
    {
        $this->assertBladeCompilesTo(
            "<?php echo app(app(Spatie\ViewComponents\ComponentFinder::class)->find(Spatie\ViewComponents\Tests\Stubs\MyComponent::class), ['color' => 'red'])->toHtml(); ?>",
            "@render(Spatie\ViewComponents\Tests\Stubs\MyComponent::class, ['color' => 'red'])"
        );
    }
}
