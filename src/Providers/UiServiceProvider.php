<?php

namespace ui\Providers;

use Illuminate\Foundation\{AliasLoader, Application};
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\{ServiceProvider, Str};
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ComponentAttributeBag;
use Livewire\LivewireBladeDirectives;
use Livewire\WireDirective;
use ui\Facades\{Ui, UiDirectives};
use ui\Support\UiTagCompiler;

/**
 * @property Application $app
 */
class UiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerTagCompiler();
        $this->registerMacros();
    }

    public function register()
    {
        $this->app->singleton('ui', ui::class);
        $loader = AliasLoader::getInstance();
        $loader->alias('ui', ui::class);
    }

    protected function registerTagCompiler()
    {
        Blade::precompiler(static function (string $string): string {
            return app(uiTagCompiler::class)->compile($string);
        });
    }

    protected function registerConfig(): void
    {
        $rootDir = __DIR__ . '/../..';

        $this->loadViewsFrom("{$rootDir}/resources/views", 'ui');
        $this->loadTranslationsFrom("{$rootDir}/src/lang", 'ui');
        $this->mergeConfigFrom("{$rootDir}/src/config/ui.php", 'ui');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->publishes(
            ["{$rootDir}/src/config/ui.php" => config_path('ui.php')],
            'ui.config'
        );

        $this->publishes(
            ["{$rootDir}/resources/views" => resource_path('views/vendor/ui')],
            'ui.resources'
        );

        $this->publishes(
            ["{$rootDir}/src/lang" => $this->app->langPath('vendor/ui')],
            'ui.lang'
        );
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('confirmAction', static function (string $expression): string {
            return uiDirectives::confirmAction($expression);
        });

        Blade::directive('notify', static function (string $expression): string {
            return uiDirectives::notify($expression);
        });

        Blade::directive('uiScripts', static function (?string $attributes = ''): string {
            if (!$attributes) {
                $attributes = '[]';
            }

            return "{!! ui::directives()->scripts(attributes: {$attributes}) !!}";
        });

        Blade::directive('uiStyles', static function (): string {
            return uiDirectives::styles();
        });

        Blade::directive('boolean', static function ($value): string {
            return uiDirectives::boolean($value);
        });

        Blade::directive('toJs', static function ($expression): string {
            return LivewireBladeDirectives::js($expression);
        });
    }

    protected function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            foreach (config('ui.components') as $component) {
                $blade->component($component['class'], $component['alias']);
            }
        });
    }

    protected function registerMacros(): void
    {
        ComponentAttributeBag::macro('wireModifiers', function () {
            /** @var ComponentAttributeBag $this */

            /** @var WireDirective $model */
            $model = $this->wire('model');

            return [
                'defer'    => $model->modifiers()->contains('defer'),
                'lazy'     => $model->modifiers()->contains('lazy'),
                'debounce' => [
                    'exists' => $model->modifiers()->contains('debounce'),
                    'delay'  => (string) Str::of($model->modifiers()->get(1, '750'))->replace('ms', ''),
                ],
            ];
        });
    }
}
