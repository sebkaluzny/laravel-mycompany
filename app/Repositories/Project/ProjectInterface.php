<?php


namespace App\Repositories\Project;


interface ProjectInterface
{
    public function all();

    public function get($id);

    public function create(array $input = []);

    public function update($model, array $input = []);
}