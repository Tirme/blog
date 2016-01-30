<?php

namespace App\Podm\Repositories\Admin;

use App\Podm\Repositories\Repository;
use App\Podm\Eloquence\AdminUser as AdminUserModel;

class UserRepository extends Repository {

    public function auth($email, $password) {
        $admin_user = AdminUserModel
            ::where('email', $email)
            ->where('password', $password)
            ->first();

        return $admin_user;
    }

}
