<?php namespace VictoryCms\Core\Resources;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use VictoryCms\Core\Resources\Grid\Cell;
use VictoryCms\Core\Resources\Grid\Row;
use VictoryCms\Core\Resources\Traits\HasChildElementsTrait;

/**
 * Class Grid.
 */
class Grid extends Element
{
    /**
     * @var bool
     */
    protected $paginate = true;

    /**
     * @var
     */
    protected $source;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $reserved = [
        'source',
    ];

    use HasChildElementsTrait {
        add as protected _add;
    }

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->app = \App::make('app');

        $this->setAttributes($this->options);
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     */
    public function options(array $options)
    {
        $this->options = array_merge([
            'class' => 'table',
        ], $options);

        if ($this->options['source'] !== null) {
            $this->populate($this->options['source']);
        }

        $this->setAttributes(array_merge($this->attributes, array_except($this->options, $this->reserved)));
    }

    /**
     * @param Row $row
     *
     * @return Row
     */
    public function add(Row $row)
    {
        return $this->_add($row);
    }

    /**
     * @param $source
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function populate($source)
    {
        if ($source instanceof QueryBuilder || $source instanceof EloquentBuilder) {
            $source = $source->get();
        }

        if (!is_array($source) && !$source instanceof \Traversable) {
            throw new \Exception('The source is not traversable');
        }

        foreach ($source as $record) {
            $this->add($row = new Row());

            if (method_exists($record, 'toArray')) {
                $record = $record->toArray();
            }

            foreach ($record as $value) {
                $row->add(new Cell($value));
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.grid.base', [
            'rows' => $this->getElements(),
        ]);
    }
}
