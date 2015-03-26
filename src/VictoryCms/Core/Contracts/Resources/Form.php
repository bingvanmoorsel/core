<?php namespace VictoryCms\Core\Contracts\Resources;

use VictoryCms\Core\Contracts\Resources\Form\Behavior\HasChildElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface Form.
 */
interface Form extends Element, HasChildElements
{
    /**
     * @param array $options
     *
     * @return Form
     */
    public function options(array $options);

    /**
     * @return string
     */
    public function getAction();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return Model
     */
    public function getModel();
}
