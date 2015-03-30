<?php namespace VictoryCms\Core\Resources\Grid;

use VictoryCms\Core\Resources\Element;
use App\Resource\Contracts\Row as RowContract;
use VictoryCms\Core\Resources\Traits\HasChildElementsTrait;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;

/**
 * Class Row.
 */
class Row extends Element implements RowContract
{
    use HasParentElementTrait;
    use HasChildElementsTrait {
        add as protected _add;
    }

    /**
     * @param Cell $cell
     *
     * @return Cell
     */
    public function add(Cell $cell)
    {
        return $this->_add($cell);
    }

    public function populate($source)
    {
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.grid.row', [
            'attributes' => $this->buildAttributes(),
            'cells'      => $this->getElements(),
        ]);
    }
}