<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded=[];
    public function questions(){
        return$this->belongsTo(Answer::class,'question_id','id');
    }
    public function responses(){
        return $this->hasMany(SurveyResponse::class,'answer_id','id');
    }
}
