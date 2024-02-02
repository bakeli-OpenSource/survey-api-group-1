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
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

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
        }catch(Exception $e){
            // Autres erreurs
        return response()->json([
            'status code' => 500,
            'status message' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
            'error' => $e->getMessage(),
        ], 500);   
        }
    }
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        if(Auth::attempt($request->only(['email', 'password']))){

            $user = auth()->user();
            // $token = $user->createToken('MY_KEY_BACKEND')->plainTextToken;
            // Génération du token et mise à jour de l'utilisateur
            $token = Str::random(30); 
            $user->$token;
            // $user->save();

            return response()->json([
                'status code' => 200,
                'status message' => 'Utilisateur connecté', 
                'user'=>$user,
                'token' => $token
            ]);
        }
        else{
            return response()->json([
                'status code' => 403,
                'status message' => 'Informations non valide', 
            ]);
        }
    }
}
