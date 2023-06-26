<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed comments
 */
class Posts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title', 'content'
    ];

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
