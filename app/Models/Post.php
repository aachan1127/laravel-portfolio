<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path', // ←これは今後不要になるかも
        'url',
    ];

    // 🔽 複数ファイルとのリレーション
    public function files()
    {
        return $this->hasMany(\App\Models\PostFile::class);
    }
}
