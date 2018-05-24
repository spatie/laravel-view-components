<?php

namespace Spatie\ViewComponents\Tests;

class RootNamespaceTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'view-components.root_namespace',
            \Spatie\ViewComponents\Tests\Stubs::class
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_path()
    {
        $this->assertBladeCompilesTo(
            '<?php echo app()->make(Spatie\ViewComponents\Tests\Stubs\MyComponent::class, [])->toHtml(); ?>',
            "@render('myComponent')"
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_nested_path()
    {
        $this->assertBladeCompilesTo(
            '<?php echo app()->make(Spatie\ViewComponents\Tests\Stubs\Nested\NestedComponent::class, [])->toHtml(); ?>',
            "@render('nested.nestedComponent')"
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_path_with_props()
    {
        $this->assertBladeCompilesTo(
            "<?php echo app()->make(Spatie\ViewComponents\Tests\Stubs\MyComponent::class, ['color' => 'red'])->toHtml(); ?>",
            "@render('myComponent', ['color' => 'red'])"
        );
    }
}
