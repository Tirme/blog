<?php

namespace App\Podm\Http\Middleware;

use Closure;
use Session;
use Crypt;
use App\Podm\Eloquence\AdminUser;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminAuthenticate {

    public function handle($request, Closure $next) {
        $encrypted = Session::get('AdminUser');
        try {
            $admin_user = Crypt::decrypt($encrypted);
            if ($admin_user instanceof AdminUser) {
                return $next($request);
            }
        } catch (DecryptException $e) {
            
        }
        return redirect()->route('admin_login');
    }

}
