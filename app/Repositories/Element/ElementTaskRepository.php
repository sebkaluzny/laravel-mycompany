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

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }


    public function create(array $input = [])
    {
        $m = new $this->model;

        $m->name = $input['name'];

        $m->fields = $this->getFieldsFromInput($input);

        $m->save();

        return $m;
    }

    private function getFieldsFromInput($input)
    {
        $fields = [];

        foreach ($input['fields'] as $field)
        {
            $fields[] = [
                'name' => ucfirst($field['name']),
                'unit' => $field['unit'],
            ];
        }

        return $fields;
    }

    public function update($model, array $input = [])
    {
        $model->name = $input['name'];

        $model->fields = $this->getFieldsFromInput($input);

        $model->save();

        return $model;
    }




}