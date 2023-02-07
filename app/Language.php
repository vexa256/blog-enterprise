<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }
}
