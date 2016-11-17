<?php


namespace App\Lib\ElementsExporter;


class CSVExporter extends ElementExporter
{

    function export(array $params = [])
    {
        $out = fopen('php://output', 'w');


        fputcsv($out, array_keys((array)$this->elements[0]));

        foreach($this->elements as $k => $element)
        {
            $elData = (array) $element;

            $tasks = is_array($elData['Zadania']) ? implode("\n", $elData['Zadania']) : $elData['Zadania'];

            $elData['Zadania'] = $tasks;

            // Remove 'id' param from file
            if(isset($elData['id']))
                unset($elData['id']);

            fputcsv($out, $elData);
        }

        fclose($out);

        return $out;
    }
}