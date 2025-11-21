<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
 protected $table = 'applications';
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'message',
        'resume',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
