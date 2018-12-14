<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $fillable = [
        'user_id', 'question_id', 'answer_id','is_corrected','answer_ids'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function question(){
        return $this->belongsTo('App\Models\Question');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
