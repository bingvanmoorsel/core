<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

/**
 * Interface Render
 * @package VictoryCms\Core\Form\Contracts\Behavior
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