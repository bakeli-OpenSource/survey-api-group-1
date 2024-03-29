<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class StorePostRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'questions' => 'required'

        ];
    }
    public function messages(){
        return[
        'title.required' => 'un nom doit etre fourni',
        'description.required' => 'veuillez donner une description',
        'questions.required' => 'veuillez ajouter vos questions ',
        

        ];
    }
    public function failedValidation(validator $validator){

        
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status code' => 422,
            'error' => true,
            'message' => "err de validation"
    ,
            'errorList' => $validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY

        ]));
    }
    
}
