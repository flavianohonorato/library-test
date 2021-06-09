<?php

namespace App\Services;

use App\Models\Book;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BookCreateFromISBNService
{
    protected $baseUrl = "https://api2.isbndb.com";

    public function __construct(protected string $token)
    {
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function handle(string $isbn): Book
    {
        $data = $this->getBook($isbn);

        $params = [
            'name' => $data['title'],
            'year' => Carbon::parse($data['date_published'])->format('Y')
        ];

        return DB::transaction(function () use ($params) {
            $book = new Book();
            $book->fill($params);
            $book->author_id = Str::uuid()->toString();
            $book->save();

            return $book;
        });
    }

    protected function getBook(string $isbn)
    {
        $url = "{$this->baseUrl}/books/{$isbn}";
        $response = Http::withToken($this->token)
            ->get($url);

        if (!$response->successful()) {
            throw new Exception('Book not found', 400);
        }

        return $response->json();
    }
}
