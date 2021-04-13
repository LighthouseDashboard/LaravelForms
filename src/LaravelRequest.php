<?php


namespace Lighthouse\Laravel\Forms;


use Illuminate\Http\Request;

/**
 * Class LaravelRequest
 * @package Lighthouse\Laravel\Forms
 * @see Request
 * @extends Request
 */
class LaravelRequest implements \Lighthouse\Contract\Form\Request
{

    /** @var \Illuminate\Http\Request */
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    public function get(string $key)
    {
        return $this->request->get($key);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([ $this->request, $method ], $args);
    }

}
