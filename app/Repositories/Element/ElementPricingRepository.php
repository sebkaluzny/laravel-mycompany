<?php


namespace App\Repositories\Element;


use App\Models\ElementPricing;
use App\Repositories\EloquentRepository;

class ElementPricingRepository extends EloquentRepository implements ElementPricingInterface
{

    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return ElementPricing::class;
    }

    public function index()
    {
        return $this->model->get();
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $input = [])
    {
        $model = new $this->model();

        $model->data = json_encode($input['elements']);

        $model->save();

        return $model;
    }

    public function update($model, array $input = [])
    {
        $model->data = json_encode($input['elements']);

        $model->save();

        return $model;
    }


    public function getCurrentElementInformations($pricing)
    {

    }


}