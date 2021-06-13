<?php

namespace Tests\Unit\Services;

use App\Models\Book;
use App\Services\BookCreateFromISBNService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Ciareis\Bypass\Bypass;
use Ciareis\Bypass\Route;
use Exception;

class BookCreateFromISBNServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book_with_isbn()
    {
        $isbn = "9788538302759";
        $bypass = Bypass::serve(
            Route::ok(uri: "/books/{$isbn}", body: $this->getBody())
        );

        $service = new BookCreateFromISBNService("token");

        $service->setBaseUrl((string) $bypass);
        $response = $service->handle($isbn);
        $this->assertInstanceOf(Book::class, $response);
    }

    public function test_returns_exception()
    {
        $this->expectException(Exception::class);

        $isbn = "9788538302759";
        $service = new BookCreateFromISBNService("token");

        $service->handle($isbn);
    }

    protected function getBody()
    {
        return [
        "title" => "Propósitos (em Portuguese Do Brasil)",
        "title_long" => "Portuguese Purpose Driven Life, Para Que Estou Na Terra? Uma Vida Com",
        "isbn" => "8538302752",
        "isbn13" => "9788538302759",
        "dewey_decimal" => "string",
        "binding" => "string",
        "publisher" => "string",
        "language" => "string",
        "date_published" => "2013-02-01T06:00:52.400Z",
        "edition" => "string",
        "pages" => 0,
        "dimensions" => "string",
        "overview" => "string",
        "image" => "string",
        "msrp" => 0,
        "excerpt" => "string",
        "synopsys" => "string",
        "authors" => [
          "Rick Warren"
        ],
        "subjects" => [
          "string"
        ],
        "reviews" => [
          "string"
        ],
        "prices" => [
          [
            "condition" => "string",
            "merchant" => "string",
            "merchant_logo" => "string",
            "merchant_logo_offset" => [
              "x" => "string",
              "y" => "string"
            ],
            "shipping" => "string",
            "price" => "string",
            "total" => "string",
            "link" => "string"
          ]
        ],
        "related" => [
            "type" => "string"
        ]
        ];
    }
}
