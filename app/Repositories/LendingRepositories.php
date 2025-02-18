<?php

namespace App\Repositories;

use App\Models\Lending;
use App\Models\StuffStock;

class LendingRepositories
{
    public function getAllLending()
    {
        return Lending::paginate(10);
    }
    public function checkStock(array $data)
    {
        $stuffStock = StuffStock::where('stuff_id', $data['stuff_id'])->first();

        if (!$stuffStock) {
            return response()->json("Stok barang tidak ditemukan.", 404)->send();
            exit;
        }

        if ($data['total_stuff'] > $stuffStock->total_available) { // Gunakan -> untuk mengakses property
            return response()->json("Jumlah yang dipinjam lebih dari yang tersedia.", 400)->send();
            exit;
        }

        return null;
    }
    public function find($id)
    {
        return Lending::find($id);
    }
    public function store(array $data)
    {
        try {
            $lending = Lending::create($data);

            // Kurangi total_available di StuffStock
            $stuffStock = StuffStock::where('stuff_id', $data['stuff_id'])->first();
            if ($stuffStock) {
                $stuffStock->decrement('total_available', $data['total_stuff']);
            }
            return $lending;
        } catch (\Exception $e) {
            return response()->json(["message" => "Gagal menyimpan data: " . $e->getMessage()], 500);
        }
    }
}
