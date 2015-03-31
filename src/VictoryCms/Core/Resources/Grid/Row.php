<?php namespace VictoryCms\Core\Resources\Grid;

use VictoryCms\Core\Resources\Element;
use VictoryCms\Core\Resources\Form\Elements\Checkbox;
use VictoryCms\Core\Resources\Traits\HasChildElementsTrait;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;

/**
 * Class Row.
 */
class Row extends Element
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

    /**
     * @param $source
     *
     * @return $this
     */
    public function populate($source)
    {
        if (method_exists($source, 'toArray')) {
            $source = $source->toArray();
        }

        foreach ($source as $value) {
            $cell = new Cell($value);
            $this->add($cell);
        }

        return $this;
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
