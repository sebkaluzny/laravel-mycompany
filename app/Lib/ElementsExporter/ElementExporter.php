<?php


namespace App\Lib\ElementsExporter;


use App\Models\Element;

abstract class ElementExporter
{

    protected $elements;

    /**
     * ElementExporter constructor.
     * @param Element[] $elements
     */
    public function __construct($elements)
    {
        $this->elements = $elements;
    }

    abstract function export(array $params = []);

    protected function getColumnNames()
    {
        $names = [];

        foreach (array_keys((array) $this->elements[0]) as $key)
        {
            if($key == 'id') continue;

            $names[] = isset($this->names()[$key]) ? $this->names()[$key] : $key;
        }

        return $names;
    }

    private function names()
    {
        return [
            'name'          => 'Nazwa',
            'thickness'     => 'Grubość',
            'width'         => 'Szerokość',
            'length'        => 'Długość',
            'quantity'      => 'Ilość na stanie',
            'done_quantity' => 'Ilość wykonanych',
            'note'          => 'Notka',
            'making'        => 'Materiał',
        ];
    }
}