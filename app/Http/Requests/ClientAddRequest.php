<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientAddRequest extends Request
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
            'name'=>'required',             
            'industry'=>'required',
            'status'=>'required',
            'phone'=>'required',
            'country'=>'required',
            'address'=>'required',
            'fileToUpload'=>'image|max:615|mimes:jpeg,jpg',
        ];
    }
}
