<?php namespace VictoryCms\Core\Form\Contracts;

/**
 * Interface Input.
 */
interface Input extends Element
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();
}
