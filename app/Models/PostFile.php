<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    protected $fillable = [
        'post_id',       // ← これを追加！
        'file_path',
        'file_type',
    ];
}
