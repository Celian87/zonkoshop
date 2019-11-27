<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Product;

class CartController extends Controller
{
    /*
        Mostra la pagina del carrello
    */

    public function index()
    {
        $cart = Cart::orderBy('created_at', 'desc')->get(); //scope per utente già inserito nel modello

        //return $cart; //mostra il JSON
        return view('Store.cart', ['cart' => $cart]);
    }



    /*
        Inserisci nel carrello (con AJAX e Form)
    */

    public function store(Request $request)
    {
        //Log::info("Ho ricevuto questi dati: \n".$request);
        //Validazione input
        $data = $request->validate([
            'product_id' => 'bail | required | numeric | min:0',
            'quantity' => 'bail | required | numeric | min:0',
        ]);

        $product = Product::find($data['product_id']);
        if ($product->cart->count() > 0) {
            if ($request->ajax()) return json_encode([
                "status" => "ERROR",
                "statusText" => "Questo elemento è già stato inserito nel carrello"
                ]);
            else return back();
        }
        if ($product->isDisabled()) {
            if ($request->ajax()) return json_encode([
                "status" => "ERROR",
                "statusText" => "Questo elemento non può essere acquistato"
                ]);
            else return back();
        }

        //store con array
        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ]);

        //aggiorno quantità
        $cart->product->removeStock($data['quantity']);

        if ($request->ajax()) return json_encode(["status" => "OK"]);
        else return back(); //pagina precedente
    }



    /*
        Modifica quantità elemento nel carrello (con AJAX)
    */

    public function update(Cart $cart, Request $request) {

        //Validazione
        $request->validate([
            'product_id' => 'numeric | min:0',
            'quantity' => 'required | numeric | min:0'
            ]);

        //$cart = Cart::where('product_id','=',$request['product_id'])->first();
        if ($cart->user_id != Auth::user()->id) {
            return json_encode(["status" => "INVALIDAUTH", "message" => "La richiesta contiene un ID utente che non corrisponde a quello dell'utente attuale"]);
        }

        //Aggiornamento DB
        if ($request->has('quantity')) {
            $cart->product->removeStock($request['quantity'] - $cart->quantity);
            $cart->update(['quantity' => $request['quantity']]);
        }

        //Preparo la risposta
        $new_price = $cart->product->price * $cart->quantity;
        $totale = Cart::getTotale();
        $saldo = Auth::user()->money - $totale;

        return json_encode([
            "status" => "OK",
            "newPrice" => number_format($new_price, 2, ',', '.'),
            "totale" => number_format($totale, 2, ',', '.'),
            "nuovosaldo" => number_format($saldo, 2, ',', '.')
        ]);
    }



    /*
        Elimina elemento dal carrello (con AJAX)
    */

    public function destroy(Cart $cart) {
        //Validazione
        if ($cart->user_id != Auth::user()->id) {
            return json_encode(["status" => "INVALIDAUTH", "message" => "La richiesta contiene un ID utente che non corrisponde a quello dell'utente attuale"]);
        }

        //Aggiornamento DB
        $cart->product->addStock($cart->quantity);
        $cart->delete();

        //calcolo il nuovo totale
        $totale = Cart::getTotale();
        $saldo = Auth::user()->money - $totale;

        return json_encode([
            "status"        => "OK",
            "statusText"    => "Elemento rimosso correttamente dal carrello",
            "totale"        => number_format($totale, 2, ',', '.'),
            "nuovosaldo"    => number_format($saldo, 2, ',', '.')
            ]);
    }
}
