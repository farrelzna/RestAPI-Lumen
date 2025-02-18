<?php

namespace App\Services;

use App\Repositories\StuffRepositories;

class StuffService
{
    private $stuffRepositories;

    public function __construct(StuffRepositories $stuffRepositories)
    {
        $this->stuffRepositories = $stuffRepositories;
    }

    public function index()
    {
        return $this->stuffRepositories->getAllStuff();
    }

    public function show($id)
    {
        return $this->stuffRepositories->getSpecificStuff($id);
    }

    public function store(array $data)
    {
        return $this->stuffRepositories->storeNewStuff($data);
    }

    public function update(array $data, $id)
    {
        return $this->stuffRepositories->updateStuff($data, $id);
    }

    public function trash()
    {
        return $this->stuffRepositories->getTrash();
    }

    public function destroy($id)
    {
        return $this->stuffRepositories->deleteStuff($id);
    }

    public function restore($id)
    {
        return $this->stuffRepositories->restoreTrash($id);
    }

    public function permanentDelete($id)
    {
        return $this->stuffRepositories->permanentDeleteTrash($id);
    }
}