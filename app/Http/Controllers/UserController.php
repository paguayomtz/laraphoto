<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function config() {
        return view('user/config');
    }

    public function update(Request $request) {
        // Obtener los datos del usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        // Validar el formulario
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|max:255|unique:users,email,'.$id
        ]);

        // Obtener los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Asignar los valores al nuevo objeto
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Subir imagen
        $image = $request->file('image');
        if($image) {
            // Poner nombre unico a la imagen
            $image_name = time().$image->getClientOriginalName();
            // Guardar la imagen en el storage (storage/app/users)
            Storage::disk('users')->put($image_name, File::get($image));
            // Setear el nombre de la imagen en el objeto
            $user->image = $image_name;
        }

        // Ejecutar consulta y cambios en la base de datos
        $user->update();

        return redirect()->route('config')->with(['message'=>'Usuario actualizo correcamente']);
    }

    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
    
}
