<?php namespace VictoryCms\Core\Resources\Grid\Presenters;

/**
 * Class Text.
 */
class Text extends Presenter
{
    /**
     * @return string
     */
    public function present()
    {
        return (string) $this->value;
    }
}
