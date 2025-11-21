<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
     protected $fillable = [
        'staff_id',
        'name',
        'number',
        'issue_date',
        'expiry_date',
        'status'
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
