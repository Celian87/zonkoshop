<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    //PROTEZIONE COLONNE
    protected $fillable = ['status'];

    //QUERY SCOPE

    //GLOBAL SCOPE
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_user', function(Builder $builder)  {
            if (Auth::check()) $builder->where('user_id', '=', Auth::user()->id);
            else return $builder->where('id', '<', 0); //per fare una collection vuota
        });
    }

    //RELAZIONI ELOQUENT
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity')->as('ordered');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //METODI
}
