<?php

namespace ui\Support;

use Illuminate\View\ComponentAttributeBag;
use ui\Actions\Minify;

class BladeDirectives
{
    public function scripts(bool $absolute = true, array $attributes = []): string
    {
        $route = route('ui.assets.scripts', $parameters = [], $absolute);
        $this->getManifestVersion('ui.js', $route);

        $attributes = new ComponentAttributeBag($attributes);

        return <<<HTML
        <script {$attributes->toHtml()}>{$this->hooksScript()}</script>
        <script src="{$route}" defer {$attributes->toHtml()}></script>
        HTML;
    }

    public function hooksScript(): string
    {
        $scripts = <<<JS
            window.Wireui = {
                hook(hook, callback) {
                    window.addEventListener(`ui:\${hook}`, () => callback())
                },
                dispatchHook(hook) {
                    window.dispatchEvent(new Event(`ui:\${hook}`))
                }
            }
        JS;

        return Minify::execute($scripts);
    }

    public function styles(bool $absolute = true): string
    {
        $route = route('ui.assets.styles', $parameters = [], $absolute);
        $this->getManifestVersion('ui.css', $route);

        return "<link href=\"{$route}\" rel=\"stylesheet\" type=\"text/css\">";
    }

    public function getManifestVersion(string $file, ?string &$route = null): ?string
    {
        $manifestPath = dirname(__DIR__, 2) . '/dist/mix-manifest.json';

        if (!file_exists($manifestPath)) {
            return null;
        }

        $manifest = json_decode(file_get_contents($manifestPath), $assoc = true);
        $version  = last(explode('=', $manifest["/{$file}"]));

        if ($route) {
            $route .= "?id={$version}";
        }

        return $version;
    }

    public function confirmAction(string $expression): string
    {
        return "onclick=\"window.\$ui.confirmAction($expression, '{{ \$_instance->id }}')\"";
    }

    public function notify(string $expression): string
    {
        return "onclick=\"window.\$ui.notify($expression, '{{ \$_instance->id }}')\"";
    }

    public function boolean(string $value): string
    {
        return "<?= json_encode(filter_var($value, FILTER_VALIDATE_BOOLEAN)); ?>";
    }
}
