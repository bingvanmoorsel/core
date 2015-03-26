<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 13:35
 */

namespace VictoryCms\Core\Resources\Grid\Filters;

use VictoryCms\Core\Contracts\Resources\Grid\Filter as FilterContract;

/**
 * Class Filter
 * @package VictoryCms\Core\Resources\Grid\Filters
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