<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 10:50
 */

namespace VictoryCms\Core\Resources\Grid;

use VictoryCms\Core\Resources\Element;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;

/**
 * Class Cell
 * @package VictoryCms\Core\Resources\Grid
 */
class Cell extends Element
{
    use HasParentElementTrait;

    /**
     * @var array
     */
    protected $value;

    /**
     * @param array $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.grid.cell', [
            'attributes' => $this->buildAttributes(),
            'value'      => $this->value
        ]);
    }
}