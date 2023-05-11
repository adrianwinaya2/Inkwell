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
        'content',
    ];

    public function commenter() {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}
