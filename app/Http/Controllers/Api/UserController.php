<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(RegisterUser $request){

        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:6',
        // ]);

        try{
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password , ['rounds' => 12]);
            $user->save();
            return response()->json([
                'status code' => 200,
                'status message' => 'Utilisateur enregistré',
                'user'=> $user,

            ],201);
        }catch (ValidationException $e) {
            // Erreurs de validation
            return response()->json([
                'status code' => 422,
                'status message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        // }catch(Exception $e){
        //     // Autres erreurs
        // return response()->json([
        //     'status code' => 500,
        //     'status message' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
        //     'error' => $e->getMessage(),
        // ], 500);   
        }
    }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required'
    //     ]);
    
    //     // Récupérer l'utilisateur
    //     $user = User::where('email', $request->email)->first();
    //     // $user = User::where('password', $request->password)->first();
    
    //     // Vérifier le mot de passe
    //     if ($user && Hash::check($request->password, $user->password)) {
    //         Auth::login($user);
    //         // Génération du token pour l'utilisateur
    //         $token = Str::random(60); // Par exemple, générez un token aléatoire de 60 caractères
    //         // Enregistrez le token dans la base de données ou faites ce que vous devez faire avec le token
    
    //         return response()->json([
    //             'status code' => 200,
    //             'status message' => 'Utilisateur connecté', 
    //             'user' => $user,
    //             'token' => $token
    //         ]);
    //     } else {
    //         // Si les informations d'identification ne sont pas valides, renvoyer une réponse d'erreur
    //         return response()->json([
    //             'status code' => 403,
    //             'status message' => 'Informations non valides', 
    //         ]);
    //     }
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        // Récupérer les informations de l'utilisateur
        $credentials = $request->only('email', 'password');

        // Authentifier l'utilisateur
        if (Auth::attempt($credentials)) {
            // L'utilisateur est authentifié avec succès
            return response()->json([
                'message' => 'Connexion réussie',
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('authToken')->plainTextToken
            ]);
        } else {
            // L'authentification a échoué
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }
    }
        

    public function logout(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        if ($user) {
            // Révoquer tous les tokens d'authentification de l'utilisateur
            $user->tokens()->delete();

            // Répondre avec un message JSON de succès
            return response()->json([
                'status code' => 200,
                'status message' => 'Déconnexion réussie', 
            ]);
        } else {
            // L'utilisateur n'est pas authentifié, répondre avec un message d'erreur
            return response()->json([
                'status code' => 403,
                'status message' => 'Utilisateur non authentifié', 
            ]);
        }
    }

    public function userData()
    {

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        if ($user) {
            // Répondre avec un message JSON de succès
            return response()->json([
                'status code' => 200,
                'status message' => 'Informations utilisateur récupérées avec succès',
                'user' => $user,
            ]);
            
        }else{
            return response()->json([
                'status code' => 404,
                'status message' => 'Utilisateur non trouvé',
            ]);
        }
    }
    public function update(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        if ($user) {
            // Valider les données entrantes
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email,'. $user->id,
            'password' => 'required|string|min:6',
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Hacher le mot de passe
        $user->save();

        // Répondre avec un message JSON de succès
        return response()->json([
            'status code' => 200,
            'status message' => 'Informations utilisateurs mises à jour',
            'user' => $user,
        ]);
        }
        else{
            return response()->json([
                'status code' => 404,
                'status message' => 'Utilisateur non trouvé',
            ]);
        }
        
    }

}
