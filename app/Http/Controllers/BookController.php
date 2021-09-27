<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get books at hundred records per request
        $books = Book::paginate(100);

        // if there's records
        if($books->isNotEmpty()) {
            $response = $books->map(function($data) {
                return [
                    "id"                => $data->id,
                    "name"              => $data->name,
                    "isbn"              => $data->isbn,
                    "authors"           => [$data->authors],
                    "number_of_pages"   => $data->number_of_pages,
                    "publisher"         => $data->publisher,
                    "country"           => $data->country,
                    "release_date"      => $data->release_date,
                ];
            });

            return [
                "status_code"   => 200,
                "status"        => "success",
                'data' => $response,
            ];
        }

        // else if there's no record
        return [
            "status_code"   => 200,
            "status"        => "success",
            "data"          => [],
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate form data
        $data = $request->validate([
            'name'              => 'required|string',
            'isbn'              => 'required|string',
            'authors'           => 'required|string',
            'country'           => 'required|string',
            'number_of_pages'   => 'required|integer',
            'publisher'         => 'required|string',
            'release_date'      => 'required|date',
        ]);

        // create book record
        $create_book = Book::create($data);

        // if record created
        if($create_book) {
            return [
                "status_code"   => 201,
                "status"        => "success",
                "data"          => [
                    "name"              => $create_book->name,
                    "isbn"              => $create_book->isbn,
                    "authors"           => [$create_book->authors],
                    "number_of_pages"   => $create_book->number_of_pages,
                    "publisher"         => $create_book->publisher,
                    "country"           => $create_book->country,
                    "release_date"      => $create_book->release_date,
                ]
            ];
        }

        // else if book is not created
        return [
            'error' => 'could not create book'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return [
            "status_code"   => 200,
            "status"        => "success",
            "data"          => [
                                    "name"              => $book->name,
                                    "isbn"              => $book->isbn,
                                    "authors"           => [$book->authors],
                                    "number_of_pages"   => $book->number_of_pages,
                                    "publisher"         => $book->publisher,
                                    "country"           => $book->country,
                                    "release_date"      => $book->release_date,
                                ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'name'              => 'required|string',
            'isbn'              => 'required|string',
            'authors'           => 'required|string',
            'country'           => 'required|string',
            'number_of_pages'   => 'required|integer',
            'publisher'         => 'required|string',
            'release_date'      => 'required|date',
        ]);

        $book_updated = $book->update($data);

        if($book_updated) {
            return [
                "status_code"   => 200,
                "status"        => "success",
                "message"       => 'The book ' .$book->name .' was updated successfully',
                "data"          => [
                    [
                        "name"              => $book->name,
                        "isbn"              => $book->isbn,
                        "authors"           => [$book->authors],
                        "number_of_pages"   => $book->number_of_pages,
                        "publisher"         => $book->publisher,
                        "country"           => $book->country,
                        "release_date"      => $book->release_date,
                    ]

                ]
            ];
        }
    }

    /**
     * Update alternative
     */

    public function update_alternative(Request $request, Book $book) {
        return $this->update($request, $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        // delete book
        $book->delete();

        // return response
        return [
            "status_code"   => 204,
            "status"        => "success",
            "message"       => $book->name .' was deleted successufully',
            "data"          => [],
        ];
    }

    /**
     *  Get external books
     */

    public function external_books(Request $request, $book) {

        // make a http request to external api
        $response = Http::get('https://www.anapioficeandfire.com/api/books?name='.$book);

        // if request is successful
        if($response->ok()) {
            // map through the response
            $response_collection = $response->collect()->map(function($data) {
                return [
                    "status_code"   => 200,
                    "status"        => "success",
                    "data"          => [
                        [
                            "name"              => $data['name'],
                            "isbn"              => $data['isbn'],
                            "authors"           => $data['authors'],
                            "number_of_pages"   => $data['numberOfPages'],
                            "publisher"         => $data['publisher'],
                            "country"           => $data['country'],
                            "release_date"      => $data['released'],
                        ]

                    ]
                ];
            });

            // if request has data
            if($response_collection->isNotEmpty()) {
                return $response_collection;
            }

            // else if request has no data
            return [
                "status_code"   => 200,
                "status"        => "success",
                "data"          => [],
            ];
        }

        // else if request failed
        return [
            "error" => 'could not process the request'
        ];
    }
}
