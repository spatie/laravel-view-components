<?php

namespace Spatie\ViewComponents\Tests;

use InvalidArgumentException;
use Illuminate\Support\Facades\Blade;

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
        $this->assertBladeCompilesTo(
            '<?php echo app()->make(Spatie\ViewComponents\Tests\Stubs\MyComponent::class, [])->toHtml(); ?>',
            "@render('stubs::myComponent')"
        );
    }

    /** @test */
    public function it_throws_an_exception_when_a_namespace_doesnt_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "View component namespace [nonExistingNamespace] doesn't exist."
        );

        Blade::compileString("@render('nonExistingNamespace::myComponent')");
    }
}
