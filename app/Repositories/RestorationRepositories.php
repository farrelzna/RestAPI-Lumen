<?php

namespace App\Repositories;

use App\Models\Lending;
use App\Models\StuffStock;
use App\Models\Restoration;

class RestorationRepositories
{
    public function getAllRestoration()
    {
        return Restoration::paginate(10);
    }
    public function restoration($data)
    {
        $lending = Lending::where('id', $data['lending_id'])->first();

        if (!$lending) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $totalBorrowed = $lending->total_stuff; // Total barang yang dipinjam
        $totalReturned = $data['total_good_stuff'] + $data['total_defec_stuff']; // Total barang yang dikembalikan

        if ($totalReturned > $totalBorrowed) {
            return response()->json(['message' => 'Jumlah barang yang dikembalikan melebihi jumlah barang yang dipinjam'], 400);
            exit;
        }

        if ($totalReturned < $totalBorrowed) {
            return response()->json(['message' => 'Jumlah barang yang dikembalikan kurang dari jumlah barang yang dipinjam'], 400);
            exit;
        }

        $stuffStock = StuffStock::first();
        if ($stuffStock) {
            $stuffStock->total_available += $data['total_good_stuff'];
            $stuffStock->total_defec += $data['total_defec_stuff'];
            $stuffStock->save();
        }

        return $stuffStock;
    }
    public function isPayLoadValid($data)
    {
        // contoh aturan validasi untuk membatasi jumlah field dalam payload
        $allowKeys = ['lending_id', 'total_good_stuff', 'total_defec_stuff'];

        // cek apakah ada kunci tambahan yang tidak diizinkan
        foreach ($data as $key => $value) {
            if (!in_array($key, $allowKeys)) {
                // jika data berlebih dari yang diizinkan, hentikan esekusi
                return false;
            }
        }

        return true;
    }
    public function store($data)
    {
        $this->restoration($data);
        return Restoration::create($data);
    }
}
