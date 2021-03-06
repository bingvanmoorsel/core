<?php namespace VictoryCms\Core\Contracts\Resources\Form\Behavior;

use VictoryCms\Core\Contracts\Resources\Element;
use VictoryCms\Core\Contracts\Resources\Form;

/**
 * Interface HasParentElement.
 */
interface HasParentElement
{
    /**
     * @return Element
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
