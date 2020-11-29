<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'file_path',
        'file_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
