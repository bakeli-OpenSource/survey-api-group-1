<?php

namespace App\Http\Controllers\Api;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\RegisterUser;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Http\Resources\QuestionResource;
use App\Models\Questionnaire;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérez l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur est authentifié
        if ($user) {
            // Récupérez les publications (sondages) de l'utilisateur connecté
            $posts = Post::where('user_id', $user->id)->latest()->get();
        

            // Retournez les sondages et le nombre total de posts de l'utilisateur en tant que ressource JSON
            return PostResource::collection($posts);

        } else {
            // Si l'utilisateur n'est pas authentifié, renvoyez une réponse appropriée
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }
    }



    public function count()
    {
        // Récupérez l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur est authentifié
        if ($user) {
        
            //  Récupère le nombre de posts de l'utilisateur
            $totalPosts = $user->posts()->count();

            // Retournez les sondages et le nombre total de posts de l'utilisateur en tant que ressource JSON
            return response()->json([
                'totalPosts' => $totalPosts
            ]);

        } else {
            // Si l'utilisateur n'est pas authentifié, renvoyez une réponse appropriée
            return response()->json(['message' => 'Pas de sondages créés'], 404);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StorePostRequest $request)
    {
        
        try{
            
            $post = new Post();
                
            $post->title = $request->title;
            $post->description = $request->description;
            $post->questions = json_encode($request->questions);
    
            $post->user_id = auth()->user()->id;
          
            $post->save();
        
            return response()->json([
                'status code' => 200,
                'status message' => 'les sondages ont ete ajoutes',
                'data'=> $post,
                'links'=> url("api/survey/{$post->id}")
                // 'links' => [
                //     'self' => route('questions.link', ['data' => $questionId]),
                // ],

            ]);
       }
       catch(Exception $e){
           return response()->json($e);    
       }
        
    }

    public function show($id)
    {
        try {
            // Récupérez l'utilisateur actuellement authentifié
            $user = Auth::user();

            // Vérifiez si l'utilisateur est authentifié
            if ($user) {
                // Récupérez le post spécifique de l'utilisateur connecté en fonction de son ID
                $post = Post::where('id', $id)->where('user_id', $user->id)->first();

                // Vérifiez si le post existe
                if ($post) {
                    // Retournez le post en tant que ressource JSON
                    return PostResource::collection($post);
                } else {
                    // Si le post n'est pas trouvé, retournez une réponse avec un code 404
                    return response()->json(['message' => 'Post non trouvé'], 404);
                }
            } else {
                // Si l'utilisateur n'est pas authentifié, renvoyez une réponse avec un code 401
                return response()->json(['message' => 'Utilisateur non authentifié'], 401);
            }
        } catch (Exception $e) {
            // En cas d'erreur interne du serveur, renvoyez une réponse avec un code 500 et un message d'erreur
            return response()->json(['message' => 'Erreur interne du serveur', 'error' => $e->getMessage()], 500);
        }
    }

    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response(null, 204);
    }

    // public function email(){
    //     $email = 
    // }
}
