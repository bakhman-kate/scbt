<?php

namespace App\Services;

use App\User;

interface UserServiceInterface
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function getData(User $user): array;

    /**
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data): bool;

}

