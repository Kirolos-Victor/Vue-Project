<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{

    protected $table = 'post_comment';
    public $timestamps = true;
    protected $fillable = array('post_id','comment','user_id','created_at','updated_at');
    protected $primaryKey="id";
    public function user(){
       return $this->belongsTo('App\User','user_id','id')->select(['id','name','photo']);
    }
    public function reply(){
        return $this->hasMany(CommentReply::class,'comment_id','id')    ;
    }



}
