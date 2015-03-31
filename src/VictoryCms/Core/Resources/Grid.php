<?php namespace VictoryCms\Core\Resources;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use VictoryCms\Core\Resources\Grid\Cell;
use VictoryCms\Core\Resources\Grid\Row;
use VictoryCms\Core\Resources\Traits\HasChildElementsTrait;

/**
 * Class Grid.
 */
class Grid extends Element
{
    /**
     * @var array
     */
    protected $source;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $reserved = [
        'source',
        'perPage'
    ];

    protected $alterCallback;

    use HasChildElementsTrait {
        add as protected _add;
    }

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->app = \App::make('app');

        $this->request = $this->app['request'];

        $this->options($options);
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     */
    public function options(array $options)
    {
        $this->options = array_merge([
            'class'   => 'table',
            'perPage' => 25,
            'source'  => [],
        ], $options);

        $this->populate($this->options['source']);

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
     * @return $this
     */
    public function populate($source)
    {
        /** @var Paginator source */
        $this->source = $this->transformSource($source);
        $this->source->setPath($this->request->getBasePath());

        return $this;
    }

    /**
     * @param $source
     * @return bool
     */
    protected function isQueryBuilder($source)
    {
        return $source instanceof QueryBuilder || $source instanceof EloquentBuilder;
    }

    /**
     * @param $source
     * @return bool
     */
    protected function isPaginator($source)
    {
        return $source instanceof Paginator;
    }

    /**
     * @param $source
     * @return LengthAwarePaginator
     */
    protected function transformSource($source)
    {
        if($this->isPaginator($source)) {
            return $source;
        }

        if($this->isQueryBuilder($source)) {
            return $source->paginate($this->options['perPage']);
        }

        $source = new Collection($source);

        $total  = $source->count();
        $start  = ($this->request->get('page', 1) - 1) * $this->options['perPage'];
        $source = array_slice($source->toArray(), $start, $this->options['perPage']);

        return new LengthAwarePaginator(
            $source,
            $total,
            $this->options['perPage']
        );
    }

    /**
     * @return void
     */
    protected function build()
    {
        foreach ($this->source as $record) {
            $row = with(new Row)->populate($record);
            $this->add($row);
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->build();

        return (string) view('victory.core::resource.grid.base', [
            'attributes' => $this->buildAttributes(),
            'elements'   => $this->getElements(),
            'paginator'  => $this->source->render(),
        ]);
    }
}
