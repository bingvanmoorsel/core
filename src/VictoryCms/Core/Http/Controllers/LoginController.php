<?php namespace VictoryCms\Core\Http\Controllers;

use Illuminate\Http\Response;
use VictoryCms\Core\Http\Requests\LoginRequest;
use VictoryCms\Core\Resources\Form;
use VictoryCms\Core\Resources\Form\Elements\Group;
use VictoryCms\Core\Resources\Form\Elements\Label;
use VictoryCms\Core\Resources\Form\Elements\Password;
use VictoryCms\Core\Resources\Form\Elements\Submit;
use VictoryCms\Core\Resources\Form\Elements\Text;

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
        $form = new Form(['method' => 'POST', 'route' => 'victory.auth.login']);

        $group = new Group(function ($group) {
            $group->add(new Label('email', 'Email'));
            $group->add(new Text('email', null, ['class' => 'form-control']));
        }, ['class' => 'form-group']);
        $form->add($group);

        $group = new Group(function ($group) {
            $group->add(new Label('password', 'Password'));
            $group->add(new Password('password', ['class' => 'form-control']));
        }, ['class' => 'form-group']);
        $form->add($group);

        $form->add(new Submit('Login', 'Login', ['class' => 'btn btn-primary']));

        return view('victory.core::login.login', compact('form'));
    }

    /**
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        if (!\Auth::attempt(['email' => $request->input()['email'], 'password' => $request->input()['password']])) {
            return \Redirect::back()->with('notification', 'Email and password combination does not exsists.')->withInput();
        }

        return \Redirect::route('victory.auth.home');
    }

    /**
     * @return Response
     */
    public function getLogout()
    {
        \Auth::logout();

        return \Redirect::route('victory.auth.login');
    }
}
