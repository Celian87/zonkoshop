<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'money',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Relazioni Eloquent
    public function cart() {
        return $this->hasMany(Cart::class);
    }
    public function orders() {
        return $this->hasMany(Cart::class);
    }

    //Metodi utili
    public function isAdmin() { //così non bisogna cambiare 20.000 file se decidiamo di modificare il modo in cui l'utente diventa admin
        if ($this->is_admin) return true;
        else return false;
    }
}
