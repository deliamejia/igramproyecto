<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    function index(){
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd('Post...');
        //dd('$request');
        //dd($request-> get('name'));

        //modificar el Request
        $request -> request ->add(['username'=>Str::slug($request->username)]);

        // Validar los datos del formulario
        $this -> validate($request, [
            'name' => 'required|min:5',
            'username' => 'required|unique:users|min:5|max:30', // La expresión regular /^\S*$/u asegura que no haya espacios
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'=> $request->name,
            'username' =>$request->username,
            'email' =>$request->email,
            'password' =>$request->password,
        ]);

        auth()->attempt($request ->only('email', 'password'));
        //Redireccionar
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
