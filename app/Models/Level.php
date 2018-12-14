<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';
    protected $fillable = [
        'name','number_of_questions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
