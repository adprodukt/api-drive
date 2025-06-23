<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Speciality extends Model
{
    protected $fillable = [
        "speciality",
        "code",
        "abbreviation",
    ];
    
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    } 
}
