<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JsonController extends Controller
{
    public function getJson(Request $request)
    {
        // $map = Storage::get('/public/app/N03-19_23_190101.geojson');
        // return response()->json(['mapJson' => $map]);

        $filePath = 'private/N03-19_23_190101.geojson';
        $fileName = 'N03-19_23_190101.geojson';
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        return Storage::download($filePath, $fileName, $headers);
    }
}
