<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_added_to_the_library()
    {

        $response = $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

//        $response->assertOk();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    public function test_book_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');

    }

    public function test_book_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Rich dad, Poor Dad',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'new title',
            'author' => 'new author',
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);

        $response->assertRedirect($book->path());
    }

    public function test_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
