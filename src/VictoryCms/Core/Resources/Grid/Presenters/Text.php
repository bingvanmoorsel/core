<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 13:44
 */

namespace VictoryCms\Core\Resources\Grid\Presenters;


class Text extends Presenter
{
    public function present()
    {
        return (string) $this->value;
    }
}