<?php namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository implements UserRepositoryInterface {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }
}