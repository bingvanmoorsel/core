<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 9:33
 */

namespace VictoryCms\Core\Http\Controllers;


use App\Language;
use VictoryCms\Core\Resources\Form\Elements\Group;
use VictoryCms\Core\Resources\Form;
use VictoryCms\Core\Resources\Form\Elements\Label;
use VictoryCms\Core\Resources\Form\Elements\Text;
use VictoryCms\Core\Resources\Grid;
use VictoryCms\Core\Resources\Grid\Cell;
use VictoryCms\Core\Resources\Grid\Row;

class PackageController extends Controller
{
    public function index()
    {
        $grid = new Grid();
        $grid->populate(Language::all());

        $form = new Form();

        $form->add(new Group(function($group){
            $group->add(new Label('test', 'Kan een form ook een grid bevatten?'));
        }));

        echo $form->render();
    }
}