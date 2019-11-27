<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    //PROTEZIONE COLONNE
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    //QUERY SCOPE

    //GLOBAL SCOPE
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_user', function(Builder $builder)  {
            if (Auth::check()) return $builder->where('user_id', '=', Auth::user()->id);
            else return $builder->where('id', '<', 0); //per fare una collection vuota
        });
    }

    //RELAZIONI ELOQUENT
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //METODI
    public static function getTotale() {
        $totale = 0.0;
        foreach(Cart::all() as $cart) {
            $totale += ($cart->quantity * $cart->product->price);
        }
        return $totale;
    }
}
