<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

/**
 * Interface Render.
 */
interface Render
{
    /**
     * @return string
     */
    public function render();

    /**
     * @return string
     */
    public function __toString();
}
