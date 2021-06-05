<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Models\Author;

class AuthorStoreController extends Controller
{
    public function __invoke(AuthorStoreRequest $request)
    {
        $data = $request->validated();

        $author = new Author();
        $author->fill($data);
        $author->save();

        return $author;
    }
}
