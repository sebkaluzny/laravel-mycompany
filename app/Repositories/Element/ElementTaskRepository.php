<?php


namespace App\Repositories\Element;


use App\Models\ElementTask;
use App\Repositories\EloquentRepository;

class ElementTaskRepository extends EloquentRepository implements ElementTaskInterface
{

    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return ElementTask::class;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function create(array $input = [])
    {
        $model = $this->model->create($input);

        return $model;
    }




}