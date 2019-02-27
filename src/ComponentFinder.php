<?php

namespace Spatie\ViewComponents;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Htmlable;

final class ComponentFinder
{
    /** @var string */
    private $rootNamespace;

    /** @var array */
    private $namespaces;

    public function __construct(string $rootNamespace, array $namespaces)
    {
        $this->rootNamespace = $rootNamespace;
        $this->namespaces = $namespaces;
    }

    public function find(string $identifier): string
    {
        $identifier = $this->sanitizeIdentifier($identifier);

        $componentClass = class_exists($identifier)
            ? $identifier
            : $this->expandComponentClassPath($identifier);

        if (! class_exists($componentClass)) {
            throw new InvalidArgumentException("View component [{$componentClass}] not found.");
        }

        if (! array_key_exists(Htmlable::class, class_implements($componentClass))) {
            throw new InvalidArgumentException(
                "View component [{$componentClass}] must implement Illuminate\Support\Htmlable."
            );
        }

        return $componentClass;
    }

    private function expandComponentClassPath(string $path): string
    {
        if (Str::contains($path, '::')) {
            list($namespaceAlias, $path) = explode('::', $path, 2);
        }

        $namespace = isset($namespaceAlias)
            ? $this->resolveNamespaceFromAlias($namespaceAlias)
            : $this->rootNamespace;

        return collect(explode('.', $path))
            ->map(function (string $part) {
                return ucfirst($part);
            })
            ->prepend($namespace)
            ->implode('\\');
    }

    private function resolveNamespaceFromAlias(string $alias): string
    {
        $namespace = $this->namespaces[$alias] ?? null;

        if (! $namespace) {
            throw new InvalidArgumentException("View component namespace [$alias] doesn't exist.");
        }

        return $namespace;
    }

    private function sanitizeIdentifier(string $identifier): string
    {
        $identifier = trim($identifier, '\'" ');

        return str_replace('::class', '', $identifier);
    }
}
