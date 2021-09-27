<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
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
