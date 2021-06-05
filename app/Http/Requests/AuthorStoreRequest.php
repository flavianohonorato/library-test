<?php

namespace App\Http\Requests;

class AuthorStoreRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:45'
            ],
            'birthdate' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],
            'genre' => [
                'required',
                'string',
                'max:60'
            ],
        ];
    }
}
