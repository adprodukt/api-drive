<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    protected $fillable = [
        'year',
    ];


    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }  
}
