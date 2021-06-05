<?php

namespace App\Models;

class Author extends Model
{
    public $fillable = [
        'name',
        'birthdate',
        'genre',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
