<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 13:40
 */

namespace VictoryCms\Core\Resources\Grid\Presenters;
use VictoryCms\Core\Contracts\Resources\Grid\Presenter as PresenterContract;


/**
 * Class Presenter
 * @package VictoryCms\Core\Resources\Grid\Filters
 */
abstract class Presenter implements PresenterContract
{
    /**
     * @var
     */
    protected $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}