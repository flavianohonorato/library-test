<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 * required={"name", "birthdate", "genre"}
 * )
 */
class AuthorStoreRequest extends Request
{
    /**
     * @OA\Property(property="name", type="string")
     * @OA\Property(property="birthdate", type="string", format="date")
     * @OA\Property(property="genre", type="string", description="Genre of writes")
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
