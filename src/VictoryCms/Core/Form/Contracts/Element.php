<?php namespace VictoryCms\Core\Form\Contracts;

use VictoryCms\Core\Form\Contracts\Behavior\Attribute;
use VictoryCms\Core\Form\Contracts\Behavior\Render;

/**
 * Interface Element
 * @package VictoryCms\Core\Form\Contracts
 */
interface Element extends Render, Attribute
{
    /**
     * @param Element $parent
     * @return mixed
     */
    public function register(Element $parent);
}