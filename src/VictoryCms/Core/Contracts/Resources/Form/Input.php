<?php namespace VictoryCms\Core\Contracts\Resources\Form;

use VictoryCms\Core\Contracts\Resources\Element;

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
