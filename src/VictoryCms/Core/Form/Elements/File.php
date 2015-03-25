<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class File.
 */
class File extends Input
{
    /**
     * @param string $name
     * @param array  $attributes
     */
    public function __construct($name, array $attributes = [])
    {
        parent::__construct('file', $name, null, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.file', [
            'attributes' => $this->buildAttributes()
        ]);
    }
}
