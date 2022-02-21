<?php

namespace App\Interfaces;

interface ContentInterface
{
    public function index($groupBy);

    public function store($data);

    public function show($id);

    public function where($data, string $orderBy = 'id', string $position = 'asc', $groupBy = null, string $count = 'get');

    public function update($data, $id);

    public function destroy($id);
}
