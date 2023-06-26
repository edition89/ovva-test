<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'posts_id', 'author', 'text',
    ];
}
