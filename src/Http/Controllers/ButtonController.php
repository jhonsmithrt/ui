<?php

namespace ui\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\ComponentAttributeBag;
use ui\Http\Requests\ButtonRequest;
use ui\Support\BladeCompiler;

class ButtonController extends Controller
{
    private BladeCompiler $compiler;

    public function __construct(BladeCompiler $compiler)
    {
        $this->compiler = $compiler;
    }

    public function __invoke(ButtonRequest $request): Response
    {
        $blade = <<<EOT
            <x-dynamic-component
                :component="ui::component('button')"
                {$this->attributes($request->all())->toHtml()}
            />
        EOT;

        $html = $this->compiler->compile($blade);

        return response($html)->withHeaders([
            'Content-Type'  => 'text/html; charset=utf-8',
            'Cache-Control' => 'public, only-if-cached, max-age=31536000',
        ]);
    }

    protected function attributes(array $attributes): ComponentAttributeBag
    {
        $attributes = new ComponentAttributeBag($attributes);

        return $attributes->whereDoesntStartWith(':');
    }
}
