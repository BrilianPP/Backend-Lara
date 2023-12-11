<?php

namespace App\Http\Controllers;

class fotoController extends Controller
{
    public function show($filename,$name){
        error_log($name);
        if ($name=="foto") {
            $filePath = storage_path('app/public/perusahaan/' . $filename);
        }else if ($name=="perusahaan"){
            $filePath = storage_path('app/public/perusahaan/' . $filename);
        }

        if(file_exists($filePath)){
            return response()->file($filePath);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
