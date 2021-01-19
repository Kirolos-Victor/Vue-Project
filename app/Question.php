<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded=[];
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class,'questionnaire_id','id');
    }
    public function answers(){
        return $this->hasMany(Answer::class,'question_id','id');
    }
    public function responses(){
        return $this->hasMany(SurveyResponse::class,'question_id','id');
    }
}
