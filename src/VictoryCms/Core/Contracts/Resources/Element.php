<?php namespace VictoryCms\Core\Contracts\Resources;

use VictoryCms\Core\Contracts\Resources\Behavior\HasAttributes;
use VictoryCms\Core\Contracts\Resources\Behavior\CanRender;

/**
 * Interface Element.
 */
interface Element extends CanRender, HasAttributes
{
    /**
     * @param Element $parent
     *
     * @return void
     */
    public function register(Element $parent);
}
