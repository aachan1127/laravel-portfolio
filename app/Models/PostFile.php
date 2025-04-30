<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostFile extends Model
{
    protected $fillable = ['post_id', 'file_path', 'file_type'];

    // ここがカギ！
    public function getUrlAttribute(): string
    {
        // すでに http で始まっていればそのまま返す
        return Str::startsWith($this->file_path, 'http')
            ? $this->file_path
            : Storage::disk('s3')->url($this->file_path);
    }
}
