<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        "year_id",
        "speciality_id",
        "group",
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
