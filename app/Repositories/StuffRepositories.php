<?php

namespace App\Repositories;

use App\Models\Stuff;

// memisahkan logika data dengan controller , jadi isinya berupa fungsi-fungsi orm / eloquent dengan model

class StuffRepositories
{
    public function getAllStuff()
    {
        return Stuff::paginate(10);
    }
    public function getSpecificStuff($id)
    {
        return Stuff::find($id);
    }
    public function storeNewStuff(array $data)
    {
        return Stuff::create($data);
    }
    public function updateStuff(array $data, $id)
    {
        Stuff::where('id', $id)->update($data);

        return Stuff::find($id);
    }
    public function getTrash()
    {
        return Stuff::onlyTrashed()->get();
    }
    public function deleteStuff($id)
    {
        $result = Stuff::where('id', $id)->first();
        $result->delete();
        return $result;
    }
    public function restoreTrash($id)
    {
        $restore = Stuff::onlyTrashed()->where('id', $id)->restore();
        return Stuff::find($id);
    }
    public function permanentDeleteTrash($id)
    {
        $delete = Stuff::onlyTrashed()->where('id', $id)->forceDelete();
        return NULL;
    }
}