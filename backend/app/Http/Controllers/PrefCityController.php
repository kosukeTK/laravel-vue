<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrefCityController extends Controller
{
    public function prefCity(Request $request)
    {
        $filePath = 'private/pref_city.json';
        $fileName = 'pref_city.json';
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        return Storage::download($filePath, $fileName, $headers);
    }
}
