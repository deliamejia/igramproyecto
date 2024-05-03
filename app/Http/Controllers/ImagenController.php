<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Intervention\Image\ImagManager;
use Intervention\Image\Facades\Image;


class ImagenController extends Controller
{
    //
    public function store( Request $request){
        if($request->hasFile('images')){
            $imagen = $request->file('images');
            $nombreImagen = Str::uuid() .".". $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath = public_path('uploads') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }
        //return "Desde imagen Controller";
        return response()->json(['images'=> $nombreImagen]);
        //$imagen = $request -> file('file');
        //return response()->json(['images'=> $imagen ->extension()]);
    }
}
