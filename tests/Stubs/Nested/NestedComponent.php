<?php

namespace Spatie\ViewComponents\Tests\Stubs\Nested;

use Illuminate\Contracts\Support\Htmlable;

class NestedComponent implements Htmlable
{
    public function toHtml(): string
    {
        return 'Hello';
    }
}
