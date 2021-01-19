<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('cart', 'user_id');
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
