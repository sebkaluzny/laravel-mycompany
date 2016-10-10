<?php


namespace App\Repositories\Element;


interface ElementPricingInterface
{
    public function get($id);

    public function create(array $input = []);
}