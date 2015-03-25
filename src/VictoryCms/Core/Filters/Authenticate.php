<?php namespace VictoryCms\Core\Filters;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;

/**
 * Class Authenticate.
 */
class Authenticate
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Redirector
     */
    protected $redirector;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth, Redirector $redirector)
    {
        $this->auth = $auth;
        $this->redirector = $redirector;
    }

    /**
     * @param Route   $route
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function filter(Route $route, Request $request)
    {
        if (!$request->is('victory/login')) {
            if ($this->auth->guest()) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                }

                return $this->redirector->route('victory.auth.login');
            }
        }
    }
}
