<?php


namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
{
    private $app;

    protected $attributes = [];

    protected $model;

    /**
     * EloquentRepository constructor.
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;

        $this->makeModel();
    }

    /**
     * @return string|static
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            return 'Class must be an instance of Model';
        }

        return $this->model = $model->newInstance($this->attributes);
    }

    /**
     * Model class
     *
     * @return mixed
     */
    abstract function model();
}