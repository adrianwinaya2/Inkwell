<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'liker_id',
        'post_id',
    ];

    public function liker() {
        return $this->belongsTo(User::class, 'id', 'liker_id');
    }
}
