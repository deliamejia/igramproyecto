<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        //dd('Aqui se muestra el formulario');
        return view('perfil.index');
    }

    public function store (Request $request)
    {
        //dd('Guardando cambios');

        //modificar el Request
        $request->request->add(['username'=>Str::slug($request->username)]);

        $this->validate($request,[
            //'username' => 'required|unique:users|min:5|max:30',
            //'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:30',
            //'not_in:twitter,editar-perfil'],

            'username' => ['required', 'unique:users,username,' .auth()->user()->id, 'min:5', 'max:30', 'not_in:twitter,editar-perfil'],
        ]);

        if ($request->imagen) {
            //dd('Si hay imagen');
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() .".". $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardando cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);

    }
}
