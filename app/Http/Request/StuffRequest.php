<?php

namespace App\Http\Request;

use App\Models\Stuff;
use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class StuffRequest
{
    // menggunakan static agar pemanggilan menggunakan :: tanpa perlu new
    public static function validate(Request $request)
    {
        // validasi ini agar data yang diisi hanya diantara item array tersebut saja, selain dari itu akan error
        $rules = [
            'name' => 'required|min:3|max:255',
            'type' => 'required|in:' . implode(',', [
                Stuff::HTL_KLN, 
                Stuff::LAB, 
                Stuff::SARPRAS,
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

