<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth') -> except(['show', 'index']);
    }
    public function index(User $user){
        //dd('Desde muro');
        //dd(auth());
        //dd($user->id);


        $posts = Post::where('user_id', $user->id)->latest()->paginate(10);

        //dd($posts);

        return view('dashboard',[
            'user'=>$user,
            'posts'=>$posts
        ]);
    }
    public function create(){
        //dd('creando post...');
        return view('posts.create');
    }

    public function store(Request $request){
        //dd('creando publicación');
        $this->validate($request,[
            'titulo'=>'required|max:225',
            'descripcion'=>'required',
            'imagen'=>'required'
        ]);

        //Post::create([
        //    'titulo'=> $request -> titulo,
        //    'descripcion'=> $request -> descripcion,
        //    'imagen'=> $request -> imagen,
        //    'user_id'=> auth() -> user() -> id
        //]);

        //$post = new Post;
        //$post -> titulo = $request -> titulo;
        //$post -> descripcion = $request -> descripcion;
        //$post -> imagen = $request -> imagen;
        //$post -> descripcion = $request -> descripcion;

        $request  -> user() -> posts() -> create([
            'titulo'=> $request -> titulo,
            'descripcion'=> $request -> descripcion,
            'imagen'=> $request -> imagen,
            'user_id'=> auth() -> user() -> id
        ]);

        return redirect()->route('posts.index', auth() -> user()->username);

    }

    /*public function show(User $user, Post $post)
    {
        // Verificar si la publicación existe y pertenece al usuario
        if(!$post || $post->user_id !== $user->id) {
            // Redirigir al perfil del usuario
            return redirect()->route('posts.show', ['username' => $user->username]);
        }

        return view('posts.show', [
            'post' => $post,
            'user'=>$user,
        ]);
    }*/

    public function show($username, $postId){
        $user =User::where('username', $username) ->firstOrFail();
        $post =Post::where('id', $postId) ->where('user_id', $user ->id)->first();

        if(!$post){
            return redirect()->route('posts.index', $username);
        }

        return view('posts.show', [
            'post' => $post,
            'user'=>$user,
        ]);

    }

    public function destroy(Post $post)
    {
        //dd('Eliminando ', $post->id);
        //dd($post->id);

        /*if($post->user_id===auth()->user()->id){
            dd('Si es la misma persona');
        }else{
            dd('No es la misma persona');
        }*/

        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen);

        if(File::exists($imagen_path)) {
            unlink($imagen_path);

        }


        return redirect()->route('posts.index', auth()->user()->username);

    }


}
