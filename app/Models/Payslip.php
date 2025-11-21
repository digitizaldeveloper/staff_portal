<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'staff_id',
        'pay_period',
        'file_path',
    ];
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
