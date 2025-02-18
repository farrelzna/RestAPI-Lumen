<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restoration extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['user_id', 'lending_id', 'date_time', 'total_good_stuff', 'total_defec_stuff'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stuff()
    {
        return $this->belongsTo(Stuff::class);
    }
    // Relasi ke model Lending
    public function lending()
    {
        return $this->belongsTo(Lending::class);
    }
}
