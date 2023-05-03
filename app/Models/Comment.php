<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'commenter_id',
        'post_id',
    ];

    public function commenter() {
        return $this->belongsTo(User::class, 'id', 'commenter_id');
    }
}
