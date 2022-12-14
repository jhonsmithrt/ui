<?php

namespace ui\Http\Controllers;

use Illuminate\Http\Response;
use Livewire\Controllers\CanPretendToBeAFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UiAssetsController extends Controller
{
    use CanPretendToBeAFile;

    public function scripts(): Response|BinaryFileResponse
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../../dist/ui.js', $mimeType = 'application/javascript');
    }

    public function styles(): Response|BinaryFileResponse
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../../dist/ui.css', $mimeType = 'text/css');
    }
}
