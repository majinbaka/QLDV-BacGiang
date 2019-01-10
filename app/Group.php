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

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getTopFatherAttribute($value){
        $father = $this->father;
        try{
            if ($father && $father !== null)
            while($father->level >= 2){
                $father = $father->father;
            }
        }catch(\Exception $e){
            dd($father);
        }

        return $father;
    }

    public function getExceptChildrens($uuid = null){
        if($uuid === null)
            return $this->childrens->where('uuid', '<>', $this->uuid);
        else
            return $this->childrens->where('uuid', '<>', $uuid)->where('parent_id','<>', $uuid);
    }
}
