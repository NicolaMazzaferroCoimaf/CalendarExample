<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model
{
    protected $fillable = [
        'employee_id',
        'work_date',
        'hours_worked'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
