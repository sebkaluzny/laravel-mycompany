<?php


namespace App\Lib\ElementsExporter;


class CSVExporter extends ElementExporter
{

    function export(array $params = [])
    {
        $out = fopen('php://output', 'w');


        fputcsv($out, array_keys((array)$this->elements[0]));
//        fputcsv($out, $this->getColumnNames());

        foreach($this->elements as $k => $element)
        {
            $elData = (array) $element;

            // Remove 'id' param from file
            unset($elData['id']);

            fputcsv($out, $elData);
        }

        fclose($out);

        return $out;
    }
}