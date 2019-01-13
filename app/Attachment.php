<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'member_attachments';

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}
