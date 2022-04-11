<?php

namespace App\Services;

use Illuminate\Auth\TokenGuard;

class CustomTokenGuard extends TokenGuard
{
    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->header($this->inputKey, '');

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        return $token;
    }

}
