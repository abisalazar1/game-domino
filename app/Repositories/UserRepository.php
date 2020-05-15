<?php

namespace App\Repositories;

use App\User;

class UserRepository extends Repository
{
    /**
     * UserRepository Constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }


    /**
     * Gets a single user
     *
     * @param string $username
     *
     * @return User
     */
    public function findByUsername(string $username)
    {
        return $this->model->where('username', $username)->first();
    }
}
