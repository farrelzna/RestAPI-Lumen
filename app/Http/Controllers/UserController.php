<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->index();
            // response ()->json : hasil yang akan dimunculkan ketika mengakses url terkait : json {data yang mau dimunculin, https status code}
            return response()->json(UserResource::collection($users), 200);
        } catch (\Exception $err) {
            // jika try ada yang error, munculkan response berupa desk err dan statusnya 400
            return response()->json($err->getMessage(), 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $payload = LoginRequest::validate($request);
            $token = $this->userService->login($payload);

            return response()->json($token, 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            // Menggunakan validated() pada UserRequest untuk mendapatkan data yang sudah divalidasi
            $payload = UserRequest::validate($request);

            // Menyimpan user baru melalui service
            $user = $this->userService->store($payload);

            // Mengembalikan response sukses dengan status code 201 (Created)
            return response()->json(new UserResource($user), 201); // Status 201 untuk pembuatan user baru
        } catch (\Exception $err) {
            // Mengembalikan error dalam format JSON
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            // Ambil data menggunakan service
            $user = $this->userService->show($id);

            if ($user) {
                // Jika data ditemukan, kembalikan response dengan resource
                return response()->json([
                    'success' => true,
                    'data' => new UserResource($user)
                ], 200);
            } else {
                // Jika data tidak ditemukan
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $err) {
            // Tangkap exception dan kembalikan error message
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $err->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        try {
            $user = $this->userService->showAuth();
            return response()->json(new UserResource($user), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $payload = UserRequest::validate($request);
            $user = $this->userService->update($payload, $id);
            return response()->json(new UserResource($user), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->userService->logout();
            return response()->json('Logout berhasil', 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            // Panggil metode destroy dari service
            $deleted = $this->userService->destroy($id);

            if ($deleted) {
                // Jika data berhasil dihapus
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
            } else {
                // Jika data tidak ditemukan
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $err) {
            // Tangani error yang terjadi dan kembalikan respons error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $err->getMessage()
            ], 500); // Status 500 untuk error server
        }
    }
}
