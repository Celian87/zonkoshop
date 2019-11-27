<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //PROTEZIONE COLONNE
    protected $protected = ['id', 'user_id'];
    protected $fillable = ['product_id', 'content'];

    //RELAZIONI ELOQUENT
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
