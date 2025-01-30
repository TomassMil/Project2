<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\BookRequest;



class BookController extends Controller implements HasMiddleware
{
    // call auth middleware
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    // display all Books
    public function list(): View
    {
        $items = Book::orderBy('name', 'asc')->get();
        
        return view(
            'book.list',
            [
            'title' => 'Books',
            'items' => $items
            ]
        );
    }

    // display new Book form
    public function create(): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view(
                'book.form',
                [
                'title' => 'Add new book',
                'book' => new Book(),
                'authors' => $authors,
                'categories' => $categories,
            ]
        );
    }

    // validate and save Book data
    private function saveBookData(Book $book, BookRequest $request): void
    {
        $validatedData = $request->validated();
        $book->fill($validatedData);

        $book->display = (bool) ($validatedData['display'] ?? false);
        
        if ($request->hasFile('image')) {
            // here you can add code that deletes old image file when new one is uploaded
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $book->image = $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }

        $book->save();
    }

    // create new Book entry
    public function put(BookRequest $request): RedirectResponse
    {
        $book = new Book();
        $this->saveBookData($book, $request);
        
        return redirect('/books');
    }

    // display Book edit form
    public function update(Book $book): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view(
            'book.form',
            [
            'title' => 'Rediģēt grāmatu',
            'book' => $book,
            'authors' => $authors,
            'categories'=> $categories
            ]
        );
    }

    // update Book data
    public function patch(Book $book, BookRequest $request): RedirectResponse
    {
        $this->saveBookData($book, $request);

        return redirect('/books/update/' . $book->id);
    }

    // delete Book
    public function delete(Book $book): RedirectResponse
    {
        if ($book->image) {
            unlink(getcwd() . '/images/' . $book->image);
        }

        $book->delete();
        return redirect('/books');
    }

}
