<?php

namespace ui\View\Components\Inputs;

use ui\View\Components\Input;

class PasswordInput extends Input
{
    protected function getView(): string
    {
        return 'ui::components.password';
    }
}
