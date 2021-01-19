<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function questions(){
        return$this->hasMany(Question::class,'questionnaire_id','id');
    }
    public function surveys(){
        return $this->hasMany(Survey::class,'questionnaire_id','id');
    }
}
