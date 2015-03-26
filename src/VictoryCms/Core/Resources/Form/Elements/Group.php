<?php namespace VictoryCms\Core\Resources\Form\Elements;

use VictoryCms\Core\Contracts\Resources\Element as ElementContract;
use VictoryCms\Core\Resources\Element;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;
use VictoryCms\Core\Resources\Traits\HasChildElementsTrait;

/**
 * Class Group.
 */
class Group extends Element
{
    use HasParentElementTrait;
    use HasChildElementsTrait;

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
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.group', [
            'attributes' => $this->buildAttributes(),
            'elements'   => $this->getElements(),
        ]);
    }
}
