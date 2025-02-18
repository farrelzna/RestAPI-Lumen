<?php

namespace App\Repositories;

use App\Models\User;

// memisahkan logika data dengan controller , jadi isinya berupa fungsi-fungsi orm / eloquent dengan model

class USerRepositories
{
    public function getAllUser()
    {
        return User::paginate(10);
    }
    public function getSpecificUser($id)
    {
        return User::find($id);
    }
    public function storeNewUser(array $data)
    {
        return User::create($data);
    }
    public function updateUser(array $data, $id)
    {
        User::where('id', $id)->update($data);

        return User::find($id);
    }
    public function getTrash()
    {
        return User::onlyTrashed()->get();
    }
    public function deleteUser($id)
    {
        $result = User::where('id', $id)->first();
        $result->delete();
        return $result;
    }
    public function restoreTrash($id)
    {
        $restore = User::onlyTrashed()->where('id', $id)->restore();
        return User::find($id);
    }
    public function permanentDeleteTrash($id)
    {
        $delete = User::onlyTrashed()->where('id', $id)->forceDelete();
        return NULL;
    }
}