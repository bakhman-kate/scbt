<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\{Builder, Model};

class UserService
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function getData(User $user): array
    {
        return [
            'fio' => $user->getFIO(),
            'bd' => $user->getBirthday(),
            'date' => $user->getCreatedDate(),
            'is_active' => $user->getActive(),
        ];
    }

    /**
     * @param array $data
     *
     * @return Builder|Model
     */
    public function create(array $data)
    {
        return User::query()->create($data);
    }

}
