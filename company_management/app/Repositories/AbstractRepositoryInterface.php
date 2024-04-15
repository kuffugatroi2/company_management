<?php

namespace App\Repositories;

interface AbstractRepositoryInterface
{
    public function all($filter = []);

    public function store($request);

    public function edit($id);

    public function update($request, $id);

    public function destroy($id);
}
