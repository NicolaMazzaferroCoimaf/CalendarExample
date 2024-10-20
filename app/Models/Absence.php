<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'employee_id',
        'absence_date',
        'type',
        'reason'
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
