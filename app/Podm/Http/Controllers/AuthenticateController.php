<?php

namespace App\Podm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RepositoryFactory;
use Session;
use Crypt;

class AuthenticateController extends Controller
{
    protected $session_key = 'AdminUser';
    public function login(Request $request)
    {
        $errors = $request->session()->get('errors', null);
        $form = (object) [
            'action' => route('admin_login_auth'),
        ];

        return view('PodmView::authenticate.login_form', [
            'form' => $form,
            'errors' => $errors,
        ]);
    }
    public function loginAuth(Request $request)
    {
        $email = $request->input('email', null);
        $password = $request->input('password', null);
        $repository = RepositoryFactory::create('Admin\User');
        $admin_user = $repository->auth($email, md5($password));
        if ($admin_user) {
            Session::put($this->session_key, Crypt::encrypt($admin_user));

            return redirect()
                ->route('model_list', [
                    'model_name' => 'article',
                ]
            );
        } else {
            return redirect()
                ->route('admin_login')
                ->with('errors', 'Authenticate failed');
        }
    }
    public function logout(Request $request)
    {
        $request->session()
            ->forget($this->session_key);

        return redirect('/');
    }
}
