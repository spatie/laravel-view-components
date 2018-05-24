<?php

namespace Spatie\ViewComponents;

interface ComponentFinder
{
    public function find(string $identifier): string;
}
