<?php namespace VictoryCms\Core\Form\Contracts;

use VictoryCms\Core\Form\Contracts\Behavior\Group;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface Form.
 */
interface Form extends Element, Group
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
