<?php

namespace ui\Support;

use Illuminate\View\Compilers\ComponentTagCompiler;
use ui\Facades\UiDirectives;

class UiTagCompiler extends ComponentTagCompiler
{
    public function compile($value)
    {
        return $this->compileWireUiSelfClosingTags($value);
    }

    protected function compileWireUiSelfClosingTags($value)
    {
        $pattern = '/<\s*ui\:(scripts|styles)\s*\/?>/';

        return preg_replace_callback($pattern, function (array $matches) {
            $element = '<script>throw new Error("Wrong <ui:scripts /> usage. It should be <ui:scripts />")</script>';

            if ($matches[1] === 'scripts') {
                $element = UiDirectives::scripts();
            }

            if ($matches[1] === 'styles') {
                $element = UiDirectives::styles();
            }

            return $element;
        }, $value);
    }
}
