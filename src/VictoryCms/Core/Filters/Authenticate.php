<?php namespace VictoryCms\Core\Filters;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class Authenticate {

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function filter(Route $route, Request $request)
    {
        if(!$request->is('victory/login'))
        {
            if ($this->auth->guest())
            {
                if ($request->ajax())
                {
                    return response('Unauthorized.', 401);
                }
                else
                {
                    return Redirect::route('victory.auth.login');
                }
            }
        }
    }
}