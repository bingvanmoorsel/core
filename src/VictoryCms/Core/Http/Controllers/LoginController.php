<?php namespace VictoryCms\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use VictoryCms\Core\Http\Requests\LoginRequest;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    /**
     * @var
     */
    protected $auth;

    /**
     * @var
     */
    protected $user;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('victory.core::login.home');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('victory.core::login.login');
    }

    /**
     * @param LoginRequest $request
     *
     * @return mixed
     */
    public function postLogin(LoginRequest $request)
    {
        \Auth::attempt(['email' => $request->input()['email'], 'password' => $request->input()['password']]);

        return Redirect::route('victory.auth.home');
    }

    /**
     * @return mixed
     */
    public function getLogout()
    {
        \Auth::logout();

        return Redirect::route('victory.auth.login');
    }
}
