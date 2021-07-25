<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album_file extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'album_no',
        'file_path',
        'file_name',
        'head_flg',
    ];
}
