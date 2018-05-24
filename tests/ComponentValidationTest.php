<?php

namespace Spatie\ViewComponents\Tests;

use InvalidArgumentException;
use Illuminate\Support\Facades\Blade;

class ComponentValidationTest extends TestCase
{
    /** @test */
    public function it_fails_when_a_component_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("View component [App\Http\ViewComponents\DoesNotExist] not found.");

        Blade::compileString("@render('doesNotExist')");
    }

    /** @test */
    public function it_fails_when_a_component_does_not_implement_htmlable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "View component [Spatie\ViewComponents\Tests\Stubs\NonHtmlable] must implement Illuminate\Support\Htmlable."
        );

        Blade::compileString("@render(Spatie\ViewComponents\Tests\Stubs\NonHtmlable::class)");
    }
}
