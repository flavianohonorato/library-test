<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * required={"name", "birthdate", "genre"}
 * )
 */
class AuthorResource extends JsonResource
{

    /**
     * @OA\Property(property="id", type="string", format="uuid")
     * @OA\Property(property="name", type="string")
     * @OA\Property(property="birthdate", type="string", format="date")
     * @OA\Property(property="genre", type="string", description="Genre of writes")
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'genre' => $this->genre,
            'birthdate' => $this->birthdate,
        ];
    }
}
