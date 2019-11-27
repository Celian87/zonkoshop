<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Cart;

class OrdersController extends Controller
{
    /* Mostra tutti gli ordini di un utente */
    public function index() {
        $orders = Order::orderBy('created_at', 'desc')->get(); //scope per utente grazie a global scope
        return view('Orders.index', ['orders' => $orders]);
        return $orders; //restituisce il JSON (per provare)
    }

    /* Salva ordine in DB */
    public function store(Request $request) {
        //$request->all();
        $totale = Cart::getTotale();
        $cart = Cart::all();

        if (Auth::user()->money <= $totale) {
            return back()->withErrors("Non hai abbastanza GIL per completare l'acquisto");
        }

        if($cart->count() > 0) { //Non creare ordini vuoti!
            //Crea il nuovo ordine
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'In corso';
            $order->save();

            foreach ($cart as $pending) {
                $order->products()->attach($pending->product->id, ['quantity' => $pending->quantity]); //crea una entry nella tabella order_product che rappresenta il prodotto
                $pending->delete(); //elimina il prodotto dal carrello
            }

            //Scala i soldi dal conto dell'utente
            Auth::user()->money -= $totale;
            Auth::user()->update();

            return redirect(route('OrdersPage'));
        }
        else return back()->withErrors("Carrello vuoto");
    }

    /* Dettagli ordine */
    public function show(Order $order) {
        return view('Order.show', ['order' => $order]);
    }

}
