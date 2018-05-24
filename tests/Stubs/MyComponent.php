<?php

namespace Spatie\ViewComponents\Tests\Stubs;

use Illuminate\Contracts\Support\Htmlable;

class MyComponent implements Htmlable
{
    public function toHtml(): string
    {
        return 'Hello';
    }
}
