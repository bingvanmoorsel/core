<?php namespace VictoryCms\Core\Resources\Grid\Filters;

use VictoryCms\Core\Contracts\Resources\Grid\Filter as FilterContract;

/**
 * Class Filter.
 */
abstract class Filter implements FilterContract
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
