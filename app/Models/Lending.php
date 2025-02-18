<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lending extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ["stuff_id", "date_time", "name", "user_id", "notes", "total_stuff"];

    public function stuff()
    {
        return $this->belongsTo(Stuff::class);
    }
    public function restorations()
    {
        return $this->hasMany(Restoration::class);
    }
    // Relasi ke model StuffStock
    public function stuffStock()
    {
        return $this->belongsTo(StuffStock::class, 'stuff_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
