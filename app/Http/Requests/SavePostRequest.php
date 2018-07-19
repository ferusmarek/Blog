<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
                'title' => 'required|max:200',
                'text'  => 'required',
                'tags'  => 'array',
                 ];

        //validacia pre pole hodnot
        $count= count($this->input('items'))-1;
        foreach (range(0,$count) as $index) {
            $rules["items.$index"] = 'mimes:txt,pdf,doc,xls';
        }
        return $rules;
    }
//validacna message
    public function messages(){
        $messages=[];
        if($this->file('items')){
        foreach ($this->file('items') as $key => $val) {
            $messages["items.$key.mimes"]= "All files must be of type: :values";
        }    }
        return $messages;
    }
}
