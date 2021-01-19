<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table = 'likes';
    public $timestamps = true;
    protected $fillable = array('id', 'user_id','post_id');
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function post(){
        return $this->belongsTo(PagePost::class,'post_id','id');
    }
}
