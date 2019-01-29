<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function scopeAdmin($query)
    {
        // This static var is only here because there is too much ask for this scope.
        // So we keep the result in "mind". An other solution (like memcached) or something better should come later
        static $adminStatic = null;
        if ($adminStatic === null)
            $adminStatic = $query->where('name', 'admin')->first()->id;



        return $adminStatic;
    }

    public function scopeSecretary($query)
    {
        // This static var is only here because there is too much ask for this scope.
        // So we keep the result in "mind". An other solution (like memcached) or something better should come later
        static $secretaryStatic = null;
        if ($secretaryStatic === null)
            $secretaryStatic = $query->where('name', 'secretary')->first()->id;

        return $secretaryStatic;
    }

    public function scopeProfessor($query)
    {
        // This static var is only here because there is too much ask for this scope.
        // So we keep the result in "mind". An other solution (like memcached) or something better should come later
        static $professorStatic = null;
        if ($professorStatic === null)
            $professorStatic = $query->where('name', 'professor')->first()->id;

        return $professorStatic;
    }
}
