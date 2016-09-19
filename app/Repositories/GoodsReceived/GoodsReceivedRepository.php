<?php


namespace App\Repositories\GoodsReceived;


use App\Models\GoodsReceived;
use App\Repositories\Element\ElementInterface;
use App\Repositories\EloquentRepository;

class GoodsReceivedRepository extends EloquentRepository implements GoodsReceivedInterface
{
    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return GoodsReceived::class;
    }

    public function index()
    {
        return $this->model->get();
    }

    public function get($id)
    {
        return $this->model->with('company')->findOrFail($id);
    }


    public function create(array $input = [])
    {
        return $this->model->create($input);
    }

    public function syncFormElements($model, array $input = [])
    {
        $elements = [];

        foreach($input['elements'] as $element)
        {
            $elements[$element['id']] = ['quantity' => $element['count']];
        }

        $model->elements()->sync($elements);

        return $elements;
    }


}