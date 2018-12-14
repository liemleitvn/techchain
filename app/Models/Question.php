<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'content', 'skill_id', 'category_id','level_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function skill(){
        return $this->belongsTo('App\Models\Skill');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function level(){
        return $this->belongsTo('App\Models\Level');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }
    public function results(){
        return $this->hasMany('App\Models\Result');
    }
}
