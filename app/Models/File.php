<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        "group_id",
        "student",
        "file_name",
        "topic",
    ];
}
