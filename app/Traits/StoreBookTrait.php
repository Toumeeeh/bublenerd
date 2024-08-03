<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait StoreBookTrait
{

    static function store($book,$location): string
    {

        $fileNameToStore = time() . '_' . uniqid() . '.' . $book->extension();

        $book->storeAs($location, $fileNameToStore, 'public');

        return Storage::url($location.'/'.$fileNameToStore);
    }
}

