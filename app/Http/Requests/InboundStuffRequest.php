<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;


class InboundStuffRequest
{
    public static function validate(Request $request)
    {
        $rules = [
            'stuff_id' => 'required',
            'total' => 'required',
            'proof_file' => 'required|image',

        ];
        $validator = app(Factory::class)->make($request->all(), $rules);
        if ($validator->fails()) {
            response()->json($validator->errors(), 400)->send();
            exit();
        } else {
            return $validator->validate();
        }
    }
}