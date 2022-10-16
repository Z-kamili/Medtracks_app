<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EstablishmentInscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>  'required',
            'sirt_num' =>  'required|numeric',
            'contact'=> 'required|string',
            'type'=> 'required',
            'country'=> 'required',
            'region'=>'required',
            'adress'=>'required|string',
            'city'=>'required',
            'file'=>'required',
            'departement'=>'required|numeric'
        ];
    }

    public function messages()
    {
        
        return [
            'name.required' => 'une error dans le champs nom',
            'Sirt_num.required' => 'une error dans le champs sirt number',
            'Sirt_num'=> 'le champs doit etre numeric',
            'Contact.required' => 'une error dans le champs contact ',
            'Contact.numeric' => 'le champs doit etre numeric',

        ];

    }
}
