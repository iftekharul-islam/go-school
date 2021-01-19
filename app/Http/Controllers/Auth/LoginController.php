<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $login = request()->input('email');
        $field = 'email';
        request()->merge([$field => $login]);
        return $field;
    }

    public function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials = array_add($credentials, 'active', '1');
        return $credentials;
    }

    public function redirectTo(){
        $role = Auth::user()->role;

        switch ($role) {
            case 'master':
                return 'master/home';
                break;
            case 'student':
                return 'student/home';
                break;
            case 'teacher':
                return 'teacher/home';
                break;
            case 'accountant':
                return 'accountant/home';
                break;
            case 'librarian':
                return 'librarian/home';
                break;
            default:
                return '/login';
                break;
        }
    }

    public function logout () {
        auth()->logout();
        return redirect('/login');
    }
}
