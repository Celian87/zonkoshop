<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Log;

// Restituisce le viste del negozio
class StoreController extends Controller
{

    public function home() {

        $slider[0] = Product::available()->orderBy('created_at', 'desc')->take(4)->get();
        //$slider[0] = Product::available()->get(); //TEST
        $slider[1] = Product::available()->orderBy('quantity', 'desc')->where('quantity', '>', 0)->take(4)->get();
        $slider[2] = Product::available()->where('price', '<',1500)->take(4)->get();

        return view('Store.main',['slidercontent' => [
            ['products' => $slider[0], 'title' => 'Nuovi arrivi'],
            ['products' => $slider[1], 'title' => 'Ultime occasioni: comprali prima che finiscano'],
            ['products' => $slider[2], 'title' => 'Sotto i 1.500']
        ]]);
    }

    public function search(Request $request) {
        Log::info($request->all());
        $data = $request->validate([
            'prodotto' => 'required',
            'price' => 'numeric|min:0'
        ]);

        //prende tutti i prodotti che contengono la stringa di ricerca
        if (Auth::check() && Auth::user()->isAdmin()) {
            $items = Product::where('name', 'LIKE', '%'.$data['prodotto'].'%');
        }
        else { //i clienti non vedono prodotti che non possono acquistare
            $items = Product::available()->where('name', 'LIKE', '%'.$data['prodotto'].'%');
        }

        //Preparo i dati da passare alla vista
        $search = [
            'results' => $items->get(),
            'text' => $data['prodotto']
        ];
        //return $search; //TEST JSON
        return view('Store.searchresults', ['search' => $search]);

    }

    public function dashboard() {
        if (Auth::user()->isAdmin())
            return view('Store.admindashboard');
        else
            return redirect('/');
    }


    public function admindisabled() {
        if (Auth::user()->isAdmin())
            return view('Product.queryresult', [
                'tabname' => 'Prodotti disattivati',
                'title' => 'Tutti i prodotti disattivati',
                'prodlist' => Product::notAvailable()->get()
            ]);
        else
            return redirect('/');
    }

    public function showRefill() {
        if (Auth::user()->isAdmin())
            return view('Store.refill', [
                'products' => Product::where('quantity','<', 5)->get()
            ]);
        else
            return redirect()->back();
    }
}
