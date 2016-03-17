<?php namespace App\Services;

use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Entities\User;

class UserService
{
    private $userRepo;
    private $email;

    public function __construct(UserRepositoryInterface $userRepo) {
        $this->userRepo = $userRepo;
    }

    /**
     * Returns either an existing or newly creted user
     * @param $email
     * @return UserService|mixed
     */
    public function getUser($email) {
        $this->email = $email;
        $user = $this->checkIfExist($this->email);

        if (null !== $user) {
            return $user;
        }
        return $this->create();
    }

    /**
     * Checks if the use exists
     * @return mixed
     */
    private function checkIfExist() {
        return $this->userRepo->getByEmail($this->email);
    }

    /**
     * Creates a new user
     * @return static
     */
    private function create()
    {
        return User::create(['email' => $this->email]);
    }
}