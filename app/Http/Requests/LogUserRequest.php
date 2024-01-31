<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 
use App\Models\User;
class LogUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'  => 'required|email|exists:users,email',
            'password'  => 'required',
            
        ];
    }
    public function failedValidation(validator $validator){

        throw new HttpResponseException(response()->json([
            'success' => false,
            'status code' => 422,
            'error' => true,
            'message' => 'erreur de validation',
            'errorList' => $validator->errors(),
        ]));
    }
    public function messages(){
        return[
        
        'email.required' => 'Email non fourni',
        'email.email' => 'Email non valide',
        'email.exists' => 'Cette adresse n\existe pas ',
        'password.required' => 'Mot de passe non fourni',

        ];
    }
}
