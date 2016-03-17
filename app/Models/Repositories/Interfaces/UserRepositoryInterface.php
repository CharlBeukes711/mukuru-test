<?php namespace App\Models\Repositories;

interface UserRepositoryInterface {
    public function getByEmail($email);
}