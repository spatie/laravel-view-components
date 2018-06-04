<?php

namespace Spatie\ViewComponents\Tests;

use InvalidArgumentException;
use Spatie\ViewComponents\ComponentFinder;
use Spatie\ViewComponents\Tests\Stubs\MyComponent;

class NamespacesTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'view-components.namespaces',
            ['stubs' => \Spatie\ViewComponents\Tests\Stubs::class]
        );
    }

    /** @test */
    public function it_renders_a_component_from_a_path_with_an_explicit_namespace()
    {
        $this->assertEquals(
            MyComponent::class.'::class',
            $this->app->make(ComponentFinder::class)->find('stubs::myComponent')
        );
    }

    /** @test */
    public function it_throws_an_exception_when_a_namespace_doesnt_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "View component namespace [nonExistingNamespace] doesn't exist."
        );

        $this->app->make(ComponentFinder::class)->find('nonExistingNamespace::myComponent');
    }
}
