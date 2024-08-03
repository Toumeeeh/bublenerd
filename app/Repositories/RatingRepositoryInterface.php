<?php

namespace App\Repositories;

interface RatingRepositoryInterface
{

    public function index();
    public function create(array $data);
    public function sumRatingsForCourse(int $id);

}

