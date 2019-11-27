<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    //PROTEZIONE COLONNE
    protected $protected = ['id']; //(solo) questi attributi NON saranno modificabili attraverso i controller@update
    protected $fillable = ['name','category_id', 'imagepath', 'quantity', 'description','price','is_disabled']; //questi attributi, e SOLO QUESTI, saranno modificabili attraverso i controller@update


    //QUERY SCOPE
    //possiamo usare questi metodi per definire filtri da applicare alle query
    //e costruire query complesse a 'mo di Lego
    public function scopeAvailable($query) {
        /* I query scope devono restituire oggetti Builder o si perdono alcune funzioni (es. relazioni) */
        return $query->where('is_disabled','=', 0);             //così restituisce un Builder
        //return $query->where('is_disabled','=', 0)->get();    //così restituisce un Collection (praticamente un array, con questo non si possono più usare le relazioni)
    }

    public function scopeNotAvailable($query) {
        return $query->where('is_disabled','=', 1);
    }

    public function scopeOfCategory($query, $categoryID) {
        return $query->where('category_id','=',$categoryID);
    }

    //GLOBAL SCOPE
    //Applica automaticamente dei Query Scope a tutte le query
    protected static function boot()
    {
        parent::boot();

        /*aggiunge un global scope chiamato available
        (il nome dello scope serve per poterlo eventualmente disattivare) */
        /* static::addGlobalScope('available', function(Builder $builder)  {
            $builder->where('is_disabled', '=', 0);
        }); */
        //ora tutte le query tipo Product::all() diventeranno Product::all()->where('is_disabled', '=', 0);
    }


    //RELAZIONI ELOQUENT
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot('quantity')->as('ordered');
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    //METODI
    public function disable() {
        $this->update(['is_disabled' => 1]);

        //Rimuovi il prodotto da tutti i carrelli
        foreach ($this->cart()->withoutGlobalScope('current_user')->get() as $cart) {
            $this->addStock($cart->quantity);
            $cart->delete();
        }
    }
    public function enable() {
        $this->update(['is_disabled' => 0]);
    }

    public function addStock($stock_units) {
        $this->quantity = $this->quantity + $stock_units;
        $this->save();
    }
    public function removeStock($stock_units) {
        $this->quantity = $this->quantity - $stock_units;
        $this->save();
    }
    public function setStock($stock_units) {
        $this->quantity = $stock_units;
        $this->save();
    }

    public function isDisabled() {
        if ($this->is_disabled == 1) return true;
        else return false;
    }

    public function sold() {
        $orders = $this->orders()->withoutGlobalScope('current_user')->get();
        $sold = 0;
        foreach ($orders as $o) $sold += $o->ordered->quantity;
        return $sold;
    }

}
