<?php

namespace App\Services;

use App\User;

class UserService implements UserServiceInterface
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
     * @return bool
     */
    public function create(array $data): bool
    {
        $user = User::query()->create($data);

        return $user->save();
    }

}
