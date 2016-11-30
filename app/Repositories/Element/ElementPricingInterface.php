<?php


namespace App\Repositories\Element;


interface ElementPricingInterface
{
    public function index();

    public function get($id);

    public function create(array $input = []);

    public function update($model, array $input = []);

    public function getCurrentElementInformations($pricing);
}