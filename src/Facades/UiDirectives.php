<?php

namespace ui\Facades;

use Illuminate\Support\Facades\Facade;
use ui\Support\BladeDirectives;

/**
 * @method static string scripts(bool $absolute = true, array $attributes = [])
 * @method static string styles(bool $absolute = true)
 * @method static string|null getManifestVersion(string $file, ?string &$route = null)
 * @method static string confirmAction(string $expression)
 * @method static string notify(string $expression)
 * @method static string boolean(string $value)
 */
class UiDirectives extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BladeDirectives::class;
    }
}
