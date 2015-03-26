<?php namespace VictoryCms\Core\Contracts\Resources\Form\Behavior;

/**
 * Interface CanPost.
 */
interface CanPost
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();
}
