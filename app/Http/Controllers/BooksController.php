<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(BookRequest $request)
    {
        Book::create([
            'title' => request('title'),
            'author' => \request('author')
        ]);
    }

    public function update(Book $book, BookRequest $request)
    {
        $book->update($request->only(['title', 'author']));
    }
}
