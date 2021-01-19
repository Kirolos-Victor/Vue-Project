<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name','price','photo');
    protected $primaryKey='id';
    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
