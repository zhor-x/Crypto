<?php

namespace App\Interfaces;

interface ContentSourceInterface
{

    public function index();

    public function store($data);

    public function update($data, $id);

    public function destroy($id);
}
