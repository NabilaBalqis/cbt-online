<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lecturer extends Authenticatable
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nip',
        'name',
        'address',
        'password',
        'gender'
    ];

    /**
     * classroom
     *
     * return void
     */
    // public function classroom()
    // {
    //     return $this->belongsTo(Classroom::class);
    // }
}
