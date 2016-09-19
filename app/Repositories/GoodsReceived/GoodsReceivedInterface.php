<?php


namespace App\Repositories\GoodsReceived;


interface GoodsReceivedInterface
{

    public function index();

    public function get($id);

    public function create(array $input = []);

    public function syncFormElements($model, array $input = []);
}