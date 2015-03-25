<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Element as ElementContract;
use VictoryCms\Core\Form\Traits\ChildTrait;
use VictoryCms\Core\Form\Traits\GroupTrait;

/**
 * Class Group.
 */
class Group extends Element
{
    use ChildTrait;
    use GroupTrait;

    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @param callable $callback
     * @param array    $attributes
     */
    public function __construct(\Closure $callback, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->callback = $callback->bindTo($this);
    }

    /**
     * @param ElementContract $parent
     */
    public function register(ElementContract $parent)
    {
        parent::register($parent);

        call_user_func($this->callback, $this);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.group', [
            'attributes' => $this->buildAttributes(),
            'elements'   => $this->getElements(),
        ]);
    }
}
