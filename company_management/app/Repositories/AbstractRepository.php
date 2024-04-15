<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = App::make($model);
    }

    public function getModel()
    {
        return $this->model->query();
    }

    public function __call(string $name, array $arguments)
    {
        return $this->getModel()->{$name}(...$arguments);
    }

    public function all($filter = [])
    {
        return $this->getModel()->get();
    }

    public function store($request)
    {
        return $this->getModel()->create($request);
    }

    public function edit($id)
    {
        return $this->getModel()->find($id);
    }

    public function update($request, $id)
    {
        $data = $this->edit($id);
        $data->fill($request);
        $data->save();
        return $data;
    }

    public function destroy($id)
    {
        $data = $this->edit($id);
        $data->delete();
        return;
    }
}
