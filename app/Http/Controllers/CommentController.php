<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        // Validar formulario
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        // Recoger datos del formulario
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valore de mi nuevo objeto para guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        // Guargar comentario
        $comment->save();

        // Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
                            ->with([
                                'message' => 'Has publicado tu msj correctamente!!'
                            ]);       
    }

    public function delete($id) {

        // Conseguir los datos del usuario identificado
        $user = \Auth::user();
        
        // Conseguir los datos del comentario
        $comment = Comment::find($id);

        //Comprobar si el usuario identificado es dueño del comentario o de la publicacion
        if($user && $user->id == $comment->user_id || $comment->image->user_id == $user_id) {
            $comment->delete();
            return redirect()->route('image.detail', ['id'=>$comment->image_id])
                                ->with([
                                    'message' => 'Comentario eliminado correctamente!!'
                                ]);
        } else {
            return redirect()->rouet('image.detail', ['id' => $comment->image_id])
                            ->with([
                                'message' => 'Error al eliminar la publicación o imagen'
                            ]);
        }

    }
}
