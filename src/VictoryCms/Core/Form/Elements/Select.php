<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Element as ElementContract;
use VictoryCms\Core\Form\Traits\ChildTrait;
use VictoryCms\Core\Form\Traits\PostingTrait;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

/**
 * Class Select.
 */
class Select extends Element
{
    use PostingTrait;
    use ChildTrait;

    /**
     * @var
     */
    protected $initialSelected;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param string $name
     * @param mixed  $options
     * @param null   $selected
     * @param array  $attributes
     */
    public function __construct($name, $options = [], $selected = null,  array $attributes = [])
    {
        parent::__construct(array_merge($attributes, compact('name')));

        $this->name = $name;
        $this->initialSelected = $selected;

        $this->populate($options);
    }

    /**
     * @param ElementContract $parent
     */
    public function register(ElementContract $parent)
    {
        parent::register($parent);

        $this->value = $this->determineValue($this->initialSelected);
    }

    /**
     * @param mixed  $source
     * @param string $value
     * @param string $key
     *
     * @return $this
     */
    public function populate($source, $value = null, $key = 'id')
    {
        if ($source instanceof QueryBuilder || $source instanceof EloquentBuilder) {
            $source = $source->first();
        }

        if ($source instanceof Collection) {
            $source = $source->lists($value, $key);
        }

        $this->options = $source;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('resource.form.elements.select', [
            'attributes' => $this->buildAttributes(),
            'options'    => $this->getOptions(),
            'selected'   => $this->getValue(),
        ]);
    }
}
