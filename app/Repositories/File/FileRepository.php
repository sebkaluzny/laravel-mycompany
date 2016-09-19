<?php


namespace App\Repositories\File;


use App\Models\File;
use App\Repositories\EloquentRepository;
use Illuminate\Http\Request;


class FileRepository extends EloquentRepository implements FileInterface
{

    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return File::class;
    }

    public function search(array $input = [])
    {
        $files = $this->model->where('name', 'LIKE', '%'. $input['name'] .'%')->get();

        return $files;
    }

    public function create(Request $request)
    {
        $file = $request->file('file');

        if (!$file->isValid())
        {
            // TODO throw exception
            return false;
        }

        $path = $file->store('files');

        $m = new $this->model();

        $m->path = $path;

        $m->name = $request->get('name');

        $m->type = $file->getClientMimeType();

        $m->save();

        return $m;
    }
}