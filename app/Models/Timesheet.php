<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = [
        'staff_id',
        'client_id',
        'date',
        'start_time',
        'end_time',
        'break_minutes',
        'total_hours',
        'notes',
        'admin_notes',
        'status',
        'locked',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
