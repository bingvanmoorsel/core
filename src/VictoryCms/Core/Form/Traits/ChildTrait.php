<?php namespace VictoryCms\Core\Form\Traits;

use VictoryCms\Core\Form\Contracts\Form;
use VictoryCms\Core\Form\Elements\Element;

/**
 * Class ChildTrait.
 */
trait ChildTrait
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Element
     */
    protected $parent;

    /**
     * @return Element
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Element $parent
     *
     * @return Element
     */
    public function setParent(Element $parent)
    {
        return $this->parent = $parent;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $element = $this;

        while (!(($element = $element->getParent()) instanceof Form));

        return $this->form = $element;
    }

    /**
     * @param Form $form
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
    }
}
