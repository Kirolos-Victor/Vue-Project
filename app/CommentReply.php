<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $table = 'comment_reply';
    public $timestamps = true;
    protected $fillable = array('comment_id','reply','user_id','created_at','updated_at');
    protected $primaryKey="id";
    public function user(){
       return $this->belongsTo(User::class,'user_id','id');
    }
}
