<?php

namespace Spatie\ViewComponents\Tests;

use InvalidArgumentException;
use Spatie\ViewComponents\ComponentFinder;
use Spatie\ViewComponents\Tests\Stubs\NonHtmlable;

class ComponentValidationTest extends TestCase
{
    /** @test */
    public function it_fails_when_a_component_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("View component [App\Http\ViewComponents\DoesNotExist] not found.");

        $this->app->make(ComponentFinder::class)->find('doesNotExist');
    }

    /** @test */
    public function it_fails_when_a_component_does_not_implement_htmlable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "View component [Spatie\ViewComponents\Tests\Stubs\NonHtmlable] must implement Illuminate\Support\Htmlable."
        );

        $this->app->make(ComponentFinder::class)->find(NonHtmlable::class);
    }
}
