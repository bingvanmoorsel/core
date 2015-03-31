<?php namespace VictoryCms\Core\Http\Controllers;

use VictoryCms\Core\Resources\Form;
use VictoryCms\Core\Resources\Grid;

abstract class ResourceController extends Controller
{
    protected $model = [];

    public function index()
    {
        return view('victory.core::resource.index', [
            'grid' => $this->grid()->render()
        ]);
    }

    public function create()
    {
        return view('victory.core::resource.create', [
            'form' => $this->form()->render()
        ]);
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function grid()
    {
        return new Grid;
    }

    public function form()
    {
        return new Form;
    }
}