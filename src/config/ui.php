<?php

use ui\View\Components;

return [
    /*
        |--------------------------------------------------------------------------
        | Icons
        |--------------------------------------------------------------------------
        |
        | The icons config will be used in icon component as default
        | https://heroicons.com
        |
    */
    'icons' => [
        'style' => env('UI_ICONS_STYLE', 'outline'),
    ],

    /*
        |--------------------------------------------------------------------------
        | Modal
        |--------------------------------------------------------------------------
        |
        | The default modal preferences
        |
    */
    'modal' => [
        'zIndex'   => env('UI_MODAL_Z_INDEX', 'z-50'),
        'maxWidth' => env('UI_MODAL_MAX_WIDTH', '2xl'),
        'spacing'  => env('UI_MODAL_SPACING', 'p-4'),
        'align'    => env('UI_MODAL_ALIGN', 'start'),
        'blur'     => env('UI_MODAL_BLUR', false),
    ],

    /*
        |--------------------------------------------------------------------------
        | Card
        |--------------------------------------------------------------------------
        |
        | The default card preferences
        |
    */
    'card' => [
        'padding'   => env('UI_CARD_PADDING', 'px-2 py-5 md:px-4'),
        'shadow'    => env('UI_CARD_SHADOW', 'shadow-md'),
        'rounded'   => env('UI_CARD_ROUNDED', 'rounded-lg'),
        'color'     => env('UI_CARD_COLOR', 'bg-white dark:bg-secondary-800'),
    ],

    /*
        |--------------------------------------------------------------------------
        | Components
        |--------------------------------------------------------------------------
        |
        | List with UI components.
        | Change the alias to call the component with a different name.
        | Extend the component and replace your changes in this file.
        | Remove the component from this file if you don't want to use.
        |
     */
    'components' => [

        'button' => [
            'class' => Components\Button::class,
            'alias' => 'button',
        ],

    ],
];
