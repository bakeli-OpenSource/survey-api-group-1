<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantController extends Controller
{
    public function response(Request $request)
    {
        // Valider les données reçues dans la requête
        $request->validate([
            'name' => 'required|string',
            'responses' => 'required|array',
        ]);

        // Créer un nouveau participant avec son nom
        $participant = Participant::create([
            'name' => $request->name,
            'responses' => $request->responses,
        ]);

        // Retourner une réponse JSON indiquant que les réponses ont été enregistrées avec succès
        return response()->json([
            'status' => 'success',
            'message' => 'Réponses enregistrées avec succès.',
            'data' => $participant,
        ]);
    }
}
