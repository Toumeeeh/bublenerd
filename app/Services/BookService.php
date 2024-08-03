<?php

    namespace App\Services;

    use App\Exceptions\CourseCreatinoException;
    use App\Exceptions\NotFoundException;
    use App\Models\Book;
    use App\Traits\StoreBookTrait;
    use Exception;
    use Illuminate\Support\Facades\DB;

    class BookService

    {
        use StoreBookTrait;
    protected Book $book;
    public function __construct(Book $book)
    {
     $this->book=$book;
    }

    public function index()
    {
        return $this->book->get();
    }

    public function getById($id)
    {
        $book=Book::where('id',$id)->first();
        if (!$book){
            throw new NotFoundException(' Not Found');
        }
        else return $book;
    }

    public function create( array $data)
    {
        try {
            DB::beginTransaction();
            $book = new $this->book;
            $book->name = $data['name'];
            $book->book = isset($data['book'])
                ? $this->store($data['book'], 'Books')
                : null;
            $book->save();

            DB::commit();
            return $book->fresh();

        }  catch (Exception $e) {
    DB::rollBack();
    throw new CourseCreatinoException("Unable to create book: " . $e->getMessage());
    }

    }














    }
