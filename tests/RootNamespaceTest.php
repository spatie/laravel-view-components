<?php

namespace Spatie\ViewComponents\Tests;

use Spatie\ViewComponents\ComponentFinder;
use Spatie\ViewComponents\Tests\Stubs\MyComponent;
use Spatie\ViewComponents\Tests\Stubs\Nested\NestedComponent;

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
        $this->assertEquals(
            MyComponent::class.'::class',
            $this->app->make(ComponentFinder::class)->find('myComponent')
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_nested_path()
    {
        $this->assertEquals(
            NestedComponent::class.'::class',
            $this->app->make(ComponentFinder::class)->find('nested.nestedComponent')
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_path_with_props()
    {
        $this->assertBladeCompilesTo(
            "<?php echo app(app(Spatie\ViewComponents\ComponentFinder::class)->find('myComponent'), ['color' => 'red'])->toHtml(); ?>",
            "@render('myComponent', ['color' => 'red'])"
        );
    }
}
