<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Models\User;
class RegisterUser extends FormRequest
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
            
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
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
        'name.required' => 'un nom doit etre fourni',
        'email.required' => 'un email valide doit etre fourni',
        'email.unique' => 'cet email existe deja',
        'password.required' => 'un mot de passe est requis',
        ];
    }
}
