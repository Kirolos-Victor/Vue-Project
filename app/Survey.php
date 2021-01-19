<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded=[];
    public function questionnaires(){
        return $this->belongsTo(Questionnaire::class,'survey_id','id');
    }
    public function responses()
    {
        return$this->hasMany(SurveyResponse::class,'survey_id','id');
    }
}
