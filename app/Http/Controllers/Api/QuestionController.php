<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Exception;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index()
    {
        $questions = Questionnaire::all();
        return QuestionResource::collection($questions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $questionnaire=new Questionnaire();
            $questions = explode("\n", $request->input('questions'));

            $data = [];
    
            foreach ($questions as $question) {
                $data[] = ['questions' => $question];
            }
            $questionnaire->questions()->createMany($data);
            //$questionnaire=Questionnaire::insert($data);
            $questionnaire->posts_id->posts()->id;
            $questionnaire->save();
            //'posts_id' -> $post->id;

            $questionId = Questionnaire::latest()->first()->id;
            
            return response()->json([
                'status code' => 200,
                'message' => 'Questions ajoutées avec succès.',
                'data'=> $data,
                // 'links' => [
                //     'self' => route('questions.store'),
                // ],
                'links' => [
                    'self' => route('questions.link', ['data' => $questionId]),
                    url('')
                ],
            ]);
        }
        catch(Exception $e){
            return response()->json($e);    
        }

        //return redirect()->route('questions.index')->with('success', 'Questions ajoutées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        //
    }
}
