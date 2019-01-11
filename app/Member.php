<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function positionr()
    {
        return $this->belongsTo('App\Position', 'position');
    }
}
