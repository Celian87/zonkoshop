<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //PROTEZIONE COLONNE
    protected $protected = ['id'];

    //QUERY SCOPE

    //GLOBAL SCOPE


    //RELAZIONI ELOQUENT
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    //METODI
}
