<?php

use Illuminate\Support\Facades\Route;
use ui\Http\Controllers\{ButtonController, IconsController, uiAssetsController};

Route::name('ui.')->prefix('/ui')->group(function () {
    Route::get('icons/{style}/{icon}', IconsController::class)
        ->where('style', '(outline|solid)')
        ->name('icons');

    Route::get('button', ButtonController::class)->name('render.button');

    Route::get('assets/scripts', [uiAssetsController::class, 'scripts'])->name('assets.scripts');
    Route::get('assets/styles', [uiAssetsController::class, 'styles'])->name('assets.styles');
});
