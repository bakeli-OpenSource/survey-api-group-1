<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
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
        $posts = Post::all();
        return PostResource::collection($posts);
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

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            $post= Post::where('user_id', auth()->user()->id)->latest();

            return response()->json([
                'code'=>200,
               'message'=>'ok',
               'data'=>json_decode($post->questions)
            ]);

        } catch (Exception $e) {
            return response()->json($e);
            
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
}
