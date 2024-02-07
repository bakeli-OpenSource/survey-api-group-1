<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionnaire;

class LinkController extends Controller
{
    public function questionsLink(Request $request){
        //$questionsString = $request->input('questions');
        $questionId = Questionnaire::latest()->first()->id;
        
   

    return response()->json([
        'status code' => 200,
        'message' => 'Lien généré avec succès.',
        'links' => [
            'self' => route('questions.link',  ['data' => $questionId])
        ],
    ]);
    }
}
