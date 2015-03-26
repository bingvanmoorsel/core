<?php namespace VictoryCms\Core\Contracts\Resources\Behavior;

/**
 * Interface Render.
 */
interface CanRender
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
