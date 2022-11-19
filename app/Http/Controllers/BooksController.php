<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(BookRequest $request)
    {
        $book = Book::create([
            'title' => request('title'),
            'author' => \request('author')
        ]);

        return redirect($book->path());
    }

    public function update(Book $book, BookRequest $request)
    {
        $book->update($request->only(['title', 'author']));

        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('books');
    }
}
