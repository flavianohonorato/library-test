<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorCreateService
{
    public function handle(array $data): Author
    {
        return DB::transaction(function () use ($data) {
            $author = new Author();
            $author->fill($data);
            $author->save();

            return $author;
        });
    }
}
