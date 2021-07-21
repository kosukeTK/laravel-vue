<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'day',
        'user_id',
        'album_no',
        'address',
        'title',
        'comment',
        'sakujo_flg',
    ];
}
