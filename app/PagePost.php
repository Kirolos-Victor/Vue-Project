<?php

namespace App;
use App\PostComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PagePost extends Model
{
    protected $table = 'page_posts';
    public $timestamps = true;
    protected $fillable = array('content','user_id','created_at','updated_at');
    protected $primaryKey="id";

    public function user(){
         return $this->belongsTo(User::class,'user_id','id')->select(['id','name','photo']);
    }
    public function comments(){
       return $this->hasMany('App\PostComment','post_id','id');
    }
    public function likes(){
        return $this->hasMany(Likes::class,'post_id','id');
    }

}
