<?php

namespace App\Repositories;

interface QuizRepositoryInterface
{
    public function index();
    public function getById(int $courseId);
    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function getByUser(int $id);
}
