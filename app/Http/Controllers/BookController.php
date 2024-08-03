<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Services\BookService;

class BookController extends Controller
{
    protected BookService $bookService;


    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    public function index()
    {
        return $this->bookService->index();
    }

    public function getById($id)
    {
        return $this->bookService->getById($id);
    }

    public function create(StoreBookRequest $data)
    {
        return $this->bookService->create($data->safe()->all());
    }

}
