<?php


namespace App\Repositories\Element;


interface ElementInterface
{
    public function index(array $input = []);

    public function get($id);

    public function search(array $input = []);

    public function create(array $input = []);

    public function update($model, array $input = []);

    public function attachFile($model, $file);

    public function unattachFile($model, $file);

    public function attachTask($model, $task, $fields, $quantity);

    public function detachTask($model, $task);

    public function export($elements, $type, $data);

    public function exportData($elements, $data);

    /**
     * @param $model
     * @param $quantities
     * @return mixed
     */
    public function setQuantities($model, $quantities);
}