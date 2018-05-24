<?php

namespace Spatie\ViewComponents\Tests;

use Illuminate\Support\Facades\Blade;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\ViewComponents\ViewComponentsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ViewComponentsServiceProvider::class,
        ];
    }

    protected function assertBladeCompilesTo(string $expected, string $template)
    {
        $this->assertEquals($expected, Blade::compileString($template));
    }
}
