<?php namespace VictoryCms\Core\Form;

use VictoryCms\Core\Form\Elements\Element;
use VictoryCms\Core\Form\Elements\Hidden;
use VictoryCms\Core\Form\Traits\GroupTrait;
use VictoryCms\Core\Form\Contracts\Form as Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

/**
 * Class Form
 * @package VictoryCms\Core\Form
 */
class Form extends Element implements Contract
{
    /**
     * @var mixed
     */
    protected $app;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @var SessionManager
     */
    protected $session;

    /**
     * @var
     */
    protected $token;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $reserved = [
        'files', 'secure', 'route', 'url', 'model'
    ];

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $method;

    /**
     * @var
     */
    protected $action;

    /**
     * @var array
     */
    protected $spoofed = [
        'PUT', 'PATCH', 'DELETE'
    ];

    use GroupTrait;

    /**
     * @param $options
     */
    public function __construct(array $options = [])
    {
        $this->app = \App::make('app');

        $this->session = $this->app['session'];
        $this->url     = $this->app['url'];

        // Get the CSRF token
        $this->token = $this->session->getToken();

        $this->options($options);
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options = [])
    {
        $this->options = array_merge([
            'method' => 'POST',
            'model'  => null,
            'route'  => null,
            'secure' => true,
            'files'  => false,
            'accept-charset' => 'UTF-8',
        ], $this->options, $options);

        $this->method = $this->options['method'] = $this->getMethod();
        $this->action = $this->options['action'] = $this->getAction();

        if($this->options['model'] !== null) {
            $this->populate($this->options['model']);
        }

        if(in_array($this->method, $this->spoofed)) {
            $this->add(new Hidden('_method', $this->method));
        }

        if($this->options['secure'] === true) {
            $this->add(new Hidden('_token', $this->token));
        }

        if($this->options['files'] === true) {
            $this->setAttribute('enctype', 'multipart/form-data');
        }

        $this->setAttributes(array_merge($this->attributes, array_except($this->options, $this->reserved)));

        return $this;
    }

    /**
     * @param Model $model
     * @return $this
     */
    public function populate(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param Request $request
     */
    public function process(Request $request)
    {

    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        if($this->method) return $this->method;

        return $this->method = strtoupper($this->options['method']);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        if($this->action) return $this->action;

        if(isset($this->options['url'])) {
            return $this->action = $this->getUrlAction($this->options['url']);
        }

        if(isset($this->options['route'])) {
            return $this->action = $this->getRouteAction($this->options['route']);
        }

        return $this->action = $this->url->current();
    }

    /**
     * @param $url
     * @return string
     */
    protected function getUrlAction($url)
    {
        if (is_array($url))
        {
            return $this->url->to($url[0], array_slice($url, 1));
        }

        return $this->url->to($url);
    }

    /**
     * @param $route
     * @return string
     */
    protected function getRouteAction($route)
    {
        if (is_array($route))
        {
            return $this->url->route($route[0], array_slice($route, 1));
        }

        return $this->url->route($route);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('resource.form.base', [
            'attributes' => $this->buildAttributes(),
            'elements'   => $this->getElements(),
        ]);
    }
}