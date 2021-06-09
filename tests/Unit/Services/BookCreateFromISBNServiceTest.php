<?php

namespace Tests\Unit\Services;

use App\Models\Book;
use App\Services\BookCreateFromISBNService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Ciareis\Bypass\Bypass;
use Exception;

class BookCreateFromISBNServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book_with_isbn()
    {
        $isbn = "9788538302759";
        $body = '{"title": "Propósitos (em Portuguese Do Brasil)","title_long": "Portuguese Purpose Driven Life, Para Que Estou Na Terra? Uma Vida Com","8538302752": "string","9788538302759": "string","dewey_decimal": "string","binding": "string","publisher": "string","language": "string","date_published": "2013-02-01T06:00:52.400Z","edition": "string","pages": 0,"dimensions": "string","overview": "string","image": "string","msrp": 0,"excerpt": "string","synopsys": "string","authors": [  "string"],"subjects": [  "string"],"reviews": [  "string"],"prices": [  {    "condition": "string",    "merchant": "string",    "merchant_logo": "string",    "merchant_logo_offset": {      "x": "string",      "y": "string"    },    "shipping": "string",    "price": "string",    "total": "string",    "link": "string"  }],"related": {  "type": "string"}}';
        $bypass = Bypass::open();

        $bypass->addRoute(method: 'get', uri: "/books/{$isbn}", status: 200, body: $body);

        $service = new BookCreateFromISBNService("token");

        $service->setBaseUrl($bypass->getBaseUrl());
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
}
