<?php

namespace App\Services;

use App\Models\User;

/**
 * Class UserService.
 */
class UserService
{
    public function profileUpdate(array $param)
    {
        $user = auth()->user();
        $image = isset($param['image']) ? file_store($param['image'], 'assets/uploads/user/', '') : null;
        $user->image = 'assets/'.$image;
        $user->update();
        return $user;
    }
}
