<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// logika bisnis di sini

class UserService
{
    private $userRepositories;
    public function __construct(UserRepositories $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function index()
    {
        return $this->userRepositories->getAllUser();
    }

    public function login(array $data)
    {
        $token = Auth::attempt($data);

        if (!$token) {
            return response()->json('Login gagal, silahkan cek email dan password anda', 401)->send();
            exit;
        }

        // jika attempt berhasi;
        $responseToken = [
            'acces_token' => $token, // token JWT
            'user' => Auth::user(), // data user
            'token_type' => 'Bearer'
        ];

        return $responseToken;
    }

    public function show($id)
    {
        return $this->userRepositories->getSpecificUser($id);
    }

    public function showAuth()
    {
        return Auth::user();
    }

    public function store(array $data)
    {
        // 
        $data['password'] = Hash::make($data['password']);

        return $this->userRepositories->storeNewUser($data);
    }

    public function update(array $data, $id)
    {
        return $this->userRepositories->updateUser($data, $id);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json('Logout berhasil');
    }

    public function trash()
    {
        return $this->userRepositories->getTrash();
    }

    public function destroy($id)
    {
        return $this->userRepositories->deleteUser($id);
    }

    public function restore($id)
    {
        return $this->userRepositories->restoreTrash($id);
    }

    public function permanentDelete($id)
    {
        return $this->userRepositories->permanentDeleteTrash($id);
    }
}
