<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

/**
 * Interface Posting
 * @package VictoryCms\Core\Form\Contracts\Behavior
 */
interface Posting
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();
}