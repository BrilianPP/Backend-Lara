<?php

namespace App\Http\Controllers;

class berkasController extends Controller
{
    public function show($filename,$name){
        error_log($name);
        if ($name=="berkas") {
            $filePath = storage_path('app/public/pendaftar/' . $filename);
        }else if ($name=="pendaftar"){
            $filePath = storage_path('app/public/pendaftar/' . $filename);
        }

        if(file_exists($filePath)){
            return response()->file($filePath);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
