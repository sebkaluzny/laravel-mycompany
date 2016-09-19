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

    /**
     * @param $model
     * @param $quantities
     * @return mixed
     */
    public function setQuantities($model, $quantities);
}