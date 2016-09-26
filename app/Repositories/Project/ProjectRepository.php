<?php


namespace App\Repositories\Project;


use App\Models\Project;
use App\Repositories\EloquentRepository;

class ProjectRepository extends EloquentRepository implements ProjectInterface
{

    /**
     * Model class
     *
     * @return mixed
     */
    function model()
    {
        return Project::class;
    }

    public function all()
    {
        return $this->model->get()->sortByDesc(function ($project, $key) {
            return $project['elements_count'];
        });
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function create(array $input = [])
    {
        $model = $this->model->create($input);

        return $model;
    }

    public function update($model, array $input = [])
    {
        // TODO: Implement update() method.
    }
}