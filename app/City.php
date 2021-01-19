<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public $with ='governorate';
    public $timestamps = true;
    protected $fillable = array('name', 'governorate_id');
    public function governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id','id');
    }

}
