<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalInscriptionRequest extends FormRequest
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
            "first_name" =>'required',
            "last_name" =>'required',
            "Phone" =>'required|numeric|min:10|unique:professionals,Phone,'.$this->id,
            "Date_Birth" => 'required|date|date_format:Y-m-d',
            "adresse"=> 'required',
            "adeli_num"=> 'numeric|min:10|nullable',
            "profession"=>'required',
            "cni"=>'required',
            "diplome"=>'required',
            "ss_num"=> 'required',
            "RIB"=>'required',
            'departement'=>'required|numeric'
        ];
    }
}
