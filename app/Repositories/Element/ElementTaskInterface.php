<?php


namespace App\Repositories\Element;


interface ElementTaskInterface
{
    public function all();

    public function get($id);

    public function create(array $input = []);

    public function update($model, array $input = []);
}