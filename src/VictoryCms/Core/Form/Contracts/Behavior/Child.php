<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

use VictoryCms\Core\Form\Contracts\Element;
use VictoryCms\Core\Form\Contracts\Form;

/**
 * Interface Child
 * @package VictoryCms\Core\Form\Contracts\Behavior
 */
interface Child
{
    /**
     * @return mixed
     */
    public function getParent();

    /**
     * @param Element $parent
     * @return void
     */
    public function setParent(Element $parent);

    /**
     * @return Form
     */
    public function getForm();

    /**
     * @param Form $form
     * @return void
     */
    public function setForm(Form $form);
}