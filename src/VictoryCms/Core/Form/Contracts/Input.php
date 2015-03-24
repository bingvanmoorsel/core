<?php namespace VictoryCms\Core\Form\Contracts;

/**
 * Interface Input
 * @package VictoryCms\Core\Form\Contracts
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