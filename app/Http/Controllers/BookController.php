<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
// format data resource collection
use App\Http\Resources\BookResource; // import resource collection

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'message' => 'Book all resource',
            'success' => true,
            'data' => BookResource::collection(Book::all()) // ini resource collection
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
                'isbn' => 'required',
                'title' => 'required',
                'price' => 'required|integer',
                'image' => 'required'
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['message'] = $validator->messages();
            $response['data'] = null;
        }else{
            // untuk buat fitur upload 
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move('cover', $fileName); // kata cover di dalam fungsi move adalah path / directory untuk menyimpan file upload yang kita siapkan di folder public
            
            $books = new Book;
            $books->isbn = $request->isbn;
            $books->cover = $fileName; // ini diambil dari variable upload diatas
            $books->title = $request->title;
            $books->price = $request->price;

            $books->save();
            
            $response['success'] = true;
            $response['message'] = 'Book is Created!';
            $response['data'] = $books;
        }

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response['success'] = true;
        $response['message'] = 'Book ID '.$id.' Available!';
        $response['data'] = new BookResource(Book::find($id));
        
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $books = Book::find($id);
        $books->isbn = $request->isbn;
        $books->title = $request->title;
        $books->price = $request->price;

        $books->update();

        $response = [
            'message' => 'Book ID '.$id.' update successfuly!',
            'success' => true,
            'data' => $books
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $books = Book::find($id);

        if($books){
            $response['success'] = true;
            $response['message'] = "Book ID {$id} Deleted!";
            // $response['data'] = $books;
            $responseCode = 200;
            $books->delete();
        }else{
            $response['success'] = true;
            $response['message'] = "Book ID {$id} not found!";
            // $response['data'] = $books;
            $responseCode = 404;
        }

        return response()->json($response, $responseCode);
    }
}