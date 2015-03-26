<?php namespace VictoryCms\Core\Resources\Form\Elements;

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
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.file', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
