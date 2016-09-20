<?php


namespace App\Repositories\Element;


interface ElementTaskInterface
{
    public function all();

    public function create(array $input = []);
}