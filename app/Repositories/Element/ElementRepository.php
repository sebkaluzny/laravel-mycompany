<?php


namespace App\Repositories\Element;


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
        if(isset($input['search']))
        {
            return $this->search(['name' => $input['search']]);
        }
        else
        {
            return $this->model->get();
        }
    }


    public function get($id)
    {
        return $this->model->with('files', 'goodsReceived')->findOrFail($id);
    }

    public function search(array $input = [])
    {
        $elements = $this->model->where('name', 'LIKE', '%'. $input['name'] .'%')->get();

        return $elements;
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

    public function attachFile($model, $file)
    {
        $model->files()->attach(File::find($file));
    }

    public function unattachFile($model, $file)
    {
        $model->files()->detach(File::find($file)->id);
    }


    public function setQuantities($model, $quantities)
    {
        $model->quantity = $quantities['quantity'];
        $model->done_quantity = $quantities['done_quantity'];

        $model->save();
    }


}