<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = [
        'name', 'number_of_questions','is_can_add_category'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
