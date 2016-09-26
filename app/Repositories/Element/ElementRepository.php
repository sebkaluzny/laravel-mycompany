<?php


namespace App\Repositories\Element;


use App\Lib\ElementsExporter\CSVExporter;
use App\Models\Element;
use App\Models\File;
use App\Repositories\EloquentRepository;

class ElementRepository extends EloquentRepository implements ElementInterface
{

    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return Element::class;
    }

    public function index(array $input = [])
    {
        if (isset($input['search']))
        {
            return $this->search(['name' => $input['search']]);
        } else
        {
            $query = $this->model->with('tasks', 'project');

            if (isset($input['project_id']) && (int) $input['project_id'] != 0)
            {
                $query->where('project_id', (int) $input['project_id']);
            }

            return $query->get();
        }
    }

    public function search(array $input = [])
    {
        $elements = $this->model->where('name', 'LIKE', '%' . $input['name'] . '%')->get();

        return $elements;
    }

    public function get($id)
    {
        return $this->model->with('files', 'goodsReceived', 'tasks', 'project')->findOrFail($id);
    }

    public function create(array $input = [])
    {
        return $this->model->create($input);
    }

    public function update($model, array $input = [])
    {
        $model->update($input);
//
//        $model->name = $input['name'];
//        $model->thickness = $input['thickness'];
//        $model->width = $input['width'];
//        $model->length = $input['length'];
//        $model->note = $input['note'];
//
//        $model->save();

        return $model;
    }

    public function pickElements(array $elements = [])
    {
        return $this->model->whereIn('id', $elements)->get();
    }


    public function attachFile($model, $file)
    {
        $model->files()->attach(File::find($file));
    }

    public function unattachFile($model, $file)
    {
        $model->files()->detach(File::find($file)->id);
    }

    public function attachTask($model, $task, $fields, $quantity)
    {
        $values = [];

        foreach ($fields as $field)
        {
            $values[] = $field;
        }

        $model->tasks()->attach((int) $task, [
            'fields'   => json_encode($values),
            'quantity' => $quantity
        ]);
    }

    public function detachTask($model, $task)
    {
        $model->tasks()->detach($task);
    }

    public function export($elements, $type, $data)
    {
        $models = $this->model->select($this->parseColumns($data))->whereIn('id', $elements)->get();

        $exporter = new CSVExporter($models);
        $exporter->export();

//        dd($models->toJson());
    }

    private function parseColumns($data)
    {
        $columns = [];

        $columns[] = 'id';

        foreach ($data as $item)
        {
            if ($item == 'position')
            {
                $columns[] = 'name';
            } else
            {
                if ($item == 'size')
                {
                    $columns[] = 'thickness';
                    $columns[] = 'width';
                    $columns[] = 'length';
                } elseif ($item == 'tasks')
                {

                } else
                {
                    $columns[] = $item;
                }
            }
        }

        return $columns;
    }

    public function exportData($elements, $data)
    {
        $query = $this->model->select($this->parseColumns($data))->whereIn('id', $elements);

        if(in_array('tasks', $data))
        {
            $query->with('tasks');
        }

        return $query->get();
    }

    public function replicate($model, $newName)
    {
        $element = $model->replicate();
        $element->name = $newName;
        $element->push();

        // TODO auto relationship copy
        foreach($model->tasks()->get() as $task)
        {
            $element->tasks()->attach($task->id, ['fields' => $task->pivot->fields, 'quantity' => $task->pivot->quantity]);
        }

        foreach($model->files()->get() as $file)
        {
            $this->attachFile($element, $file->id);
        }

//
//        $model->relations = [];
//        $model->load('files', 'tasks');
//        $relations = $model->getRelations();
//
//        foreach ($relations as $relation)
//        {
//            foreach ($relation as $relationRecord)
//            {
//                $newRelationship = $relationRecord->replicate();
//                $newRelationship->element_id = $element->id;
//                $newRelationship->push();
//            }
//        }

        return $element;
    }


    public function setQuantities($model, $quantities)
    {
        $model->quantity = $quantities['quantity'];
        $model->done_quantity = $quantities['done_quantity'];

        $model->save();
    }


}