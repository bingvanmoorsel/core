<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

use VictoryCms\Core\Form\Contracts\Element;
use VictoryCms\Core\Form\Contracts\Form;

/**
 * Interface Child.
 */
interface Child
{
    /**
     * @return mixed
     */
    public function getParent();

    /**
     * @param Element $parent
     */
    public function setParent(Element $parent);

    /**
     * @return Form
     */
    public function getForm();

    /**
     * @param Form $form
     */
    public function setForm(Form $form);
}
