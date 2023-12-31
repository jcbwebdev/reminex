<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSubject extends Model
{
    use HasFactory;

    protected $table = 'request_subjects';

    protected $fillable = [
        're_courses',
        're_subjects',
    ];
}
