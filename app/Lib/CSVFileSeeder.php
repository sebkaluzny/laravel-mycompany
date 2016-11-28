<?php


namespace App\Lib;


use Illuminate\Database\Seeder;

abstract class CSVFileSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    }

    protected function importFileLines($file)
    {
        $fileContent = file_get_contents($file);
        return explode("\n", $fileContent);
    }

    protected function parseElements($lines, $attrs, $delimiter = ';')
    {
        $elements = [];

        foreach($lines as $line)
        {
            $explode = explode($delimiter, $line);

            $element = [];

            foreach($attrs as $i => $attr)
            {
                $element[$attr] = $explode[$i];
            }

            $elements[] = $element;
        }

        return $elements;
    }
}