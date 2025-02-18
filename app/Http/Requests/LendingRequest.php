<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory;
use illuminate\Http\Request;

class LendingRequest
{
    public static function validate(Request $request)
    {
        $request['notes'] = $request->notes ?? NULL;
        $rules = [
            'stuff_id' => 'required',
            'name' => 'required|min:3',
            'total_stuff' => 'required'
        ];

        $validator = app(Factory::class)->make($request->all(), $rules);
        if ($validator->fails()) {
            response()->json($validator->errors(), 400)->send();
            exit;
        } else {
            return $request->all();
        }
    }
}
