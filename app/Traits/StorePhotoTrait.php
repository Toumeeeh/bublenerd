<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait StorePhotoTrait
{

    static function store($photo,$location): string
    {

        $fileNameToStore = time() . '_' . uniqid() . '.' . $photo->extension();

        $photo->storeAs($location, $fileNameToStore, 'public');

        return Storage::url($location.'/'.$fileNameToStore);
    }
}

