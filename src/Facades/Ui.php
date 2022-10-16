<?php

namespace ui\Facades;

use Illuminate\Support\Facades\Facade;
use ui\Support\{BladeDirectives, ComponentResolver};

/**
 * @method static string component(string $name)
 * @method static ComponentResolver components()
 * @method static BladeDirectives directives()
 */
class Ui extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ui\ui::class;
    }
}
