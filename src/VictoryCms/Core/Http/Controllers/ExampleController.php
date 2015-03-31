<?php namespace VictoryCms\Core\Http\Controllers;

use VictoryCms\Core\Models\Hero;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Resources\Form\Elements\Group;
use VictoryCms\Core\Resources\Form;
use VictoryCms\Core\Resources\Form\Elements\Label;
use VictoryCms\Core\Resources\Form\Elements\Submit;
use VictoryCms\Core\Resources\Form\Elements\Text;
use VictoryCms\Core\Resources\Grid;

class ExampleController extends ResourceController
{
    public function grid()
    {
        return new Grid([
            'source'  => Hero::all(),
            'perPage' => 1
        ]);
    }

    public function form()
    {
        $form = new Form;

        $form->populate(Hero::find(1));

        $form->add(new Group(function($group){
            $group->add(new Text('first_name', null, ['placeholder' => 'First name']));
            $group->add(new Text('last_name', null, ['placeholder' => 'Last name']));
            $group->add(new Text('email', null, ['placeholder' => 'E-mail']));
        }, ['class' => 'form-group']));

        $form->add(new Submit());

        return $form;
    }
}
