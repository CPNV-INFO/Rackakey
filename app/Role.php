<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user(){
        return $this->hasOne('App\User');
    }

    public function scopeAdmin($query){
        return $query->where('name', 'admin')->first()->id;
    }

    public function scopeSecretary($query){
        return $query->where('name', 'secretary')->first()->id;
    }

    public function scopeProfessor($query){
        return $query->where('name', 'professor')->first()->id;
    }
}
