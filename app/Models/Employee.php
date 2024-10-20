<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function workHours()
    {
        return $this->hasMany(WorkHour::class);
    }
}
