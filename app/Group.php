<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function members()
    {
        return $this->hasMany('App\Member');
    }

    public function father()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
