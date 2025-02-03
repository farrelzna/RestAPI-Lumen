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
    public function deleteUser($id)
    {
        User::where('id', $id)->delete();

        return User::destroy($id);
    }
}