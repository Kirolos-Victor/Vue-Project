<?php

namespace App;


class Cart
{
    public $items=[];
    public $totalQty =0;
    public $totalPrice =0;
    public function __construct($cart = null)
    {
        if($cart){
            $this->items=$cart->items;
            $this->totalQty =$cart->totalQty;
            $this->totalPrice =$cart->totalPrice;
        }
    }
    public function add($product){
        $item = [
            'id'=>$product->id,
            'name'=>$product->name,
            'price'=>$product->price,
            'photo'=>$product->photo,
            'Qty' => 0,
            'qtyPrice'=>0,
            'photo'=>$product->photo,
        ];
        //lw el item msh mwguda
        if(!array_key_exists($product->id, $this->items)){
            $this->items[$product->id]=$item;
            $this->totalQty += 1;
            $this->totalPrice += $product->price;
        }
        //lw el item mwguda
        else{
            $this->totalQty += 1;
            $this->totalPrice += $product->price;
        }
        $this->items[$product->id]['Qty'] += 1;
        $this->items[$product->id]['qtyPrice'] += $this->items[$product->id]['price'];


    }
    public function remove($id){
        if(array_key_exists($id, $this->items))
        {
            $this->totalQty -=$this->items[$id]['Qty'];
            $this->totalPrice -=$this->items[$id]['price'] * $this->items[$id]['Qty'];
            //unset is used to delete the item
            unset($this->items[$id]);
        }
    }
    public function update($id,$qtyNumber)
    {
        if(array_key_exists($id,$this->items))
        {
            //reset total price and total quantity
            $this->totalQty -=$this->items[$id]['Qty'];
            $this->totalPrice -=$this->items[$id]['price'] * $this->items[$id]['Qty'];
            $this->items[$id]['qtyPrice'] -= $this->items[$id]['price'];
            //add the item with new quantity
            $this->items[$id]['Qty']=$qtyNumber;
            //new total price and total quantity
            $this->totalQty +=$this->items[$id]['Qty'];
            $this->items[$id]['qtyPrice'] = $this->items[$id]['price'] * $this->items[$id]['Qty'];
            $this->totalPrice +=$this->items[$id]['price'] * $this->items[$id]['Qty'];
            //unset($this->items[$id]);
        }

    }

}
