<?php namespace VictoryCms\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use VictoryCms\Core\Http\Requests\LoginRequest;
use VictoryCms\Core\Models\Hero;

class LoginController extends Controller
{
    protected $auth, $user;

    public function __construct()
    {
        //        $user = new Hero();
//        $user->first_name = 'Bing';
//        $user->last_name = 'van Moorsel';
//        $user->email = 'bvanmoorsel@swis.nl';
//        $user->password = 'test';
//        $user->save();
    }

    public function index()
    {
        return view('victory.core::login.home');
    }

    public function getLogin()
    {
        return view('victory.core::login.login');
    }

    public function postLogin(LoginRequest $request)
    {
        \Auth::login(Hero::find(1));

        return Redirect::route('victory.auth.home');
    }

    public function getLogout()
    {
        \Auth::logout();

        return Redirect::route('victory.auth.login');
    }
}
