<?php

namespace ui\Support;

class ComponentResolver
{
    public function resolve(string $name): string
    {
        $components = config('ui.components');

        return $components[$name]['alias'];
    }

    public function resolveClass(string $name): string
    {
        $components = config('ui.components');

        return $components[$name]['class'];
    }
}
