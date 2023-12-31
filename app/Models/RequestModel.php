<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    use HasFactory;

    protected $table = 'student_requests';

    public $timestamps = true;

    protected $fillable = [
        'stud_name',
        'department',
        'request_type',
        'period',
        'subject',
        'instructor',
        'reason',
        'time_avail1',
        'time_avail2',
        'file_name',
        'file_path',
        'status',
        'remarks',
    ];
    
}