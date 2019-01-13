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

    public function getIdsG(){
        $group = $this;
        $res = [];
        $res[] = $this->id;
        foreach ($this->childrens as $g) {
            $res = \array_merge($res, $g->getIdsG());
        }
        return $res;
    }

    public function hasRelation($id){
        if ($this->id == $id) return true;
        $t = $this->level;
        $g = Group::find($id);
        if ($g)
        {
            if($t > $g->level)
                return $this->hasFatherRelation($id);
            else
                return $this->hasChildRelation($id);
        }

        return false;
    }

    public function hasChildRelation($id){
        $childs = $this->childrens;
        $g = Group::find($id);
        foreach ($childs as $child) {
            if ($child->id == $id) return true;
            if ($child->level < $g->level) return false;
            $child->hasChildRelation($id);
        }

        return false;
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

    public function hasFatherRelation($id){
        $father = $this->father;
        try{
            if ($father && $father !== null)
            {
                if ($father->id == $id) return true;
                while($father = $father->father){
                    if ($father && $father !== null)
                    if ($father->id == $id) return true;
                }
            }
        }catch(\Exception $e){
            dd($father);
        }

        return $father !== null ? true : false;
    }

    public function getExceptChildrens($uuid = null){
        if($uuid === null)
            return $this->childrens->where('uuid', '<>', $this->uuid);
        else
            return $this->childrens->where('uuid', '<>', $uuid)->where('parent_id','<>', $uuid);
    }
}
