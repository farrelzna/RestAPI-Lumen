<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Factory;

// proses data apa saja yang masi pure

class UserRequest
{
    // menggunakan static agar pemanggilan menggunakan :: tanpa perlu new
    public static function validate($request)
    {
        $request['role'] = $request->role ?? 'STAFF';
        // validasi ini agar data yang diisi hanya diantara item array tersebut saja, selain dari itu akan error
        $rules = [
            'username' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:' . implode(',', [
                User::ADMIN, 
                User::STAFF,
            ]),
        ];
        // lumen hanya bisa validasi bentuk $this->validate($request, [.....]) tp $this hanya bisa di panggil di controller, tempat awal. jadi solusinya gunakan factory dari validation
        $validator = app(Factory::class)->make($request->all(), $rules);
        // jika validasi ada error, langsung kirim json dan exit, kodingan lainnya (di controller) tidak akan dijalankan
        if ($validator->fails()) {
            response()->json($validator->errors(), 400)->send();
            exit;
        } else {
            return $validator->validated();
        }
    }
}

