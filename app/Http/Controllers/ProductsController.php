<?php

namespace App\Http\Controllers;

use App\Product;
use Log; //Solo per debugging
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    protected $validationRules = [
        "name" => "required | min:3",
        "category_id" => "required | numeric | min:1",
        "description" => "required | min: 5",
        "price" => "numeric | min:0 | max:999999999",
        "quantity" => "integer | max:999999999"
    ];
    protected $validationMessages = [
        'name.required' => '\':attribute\' non può essere vuoto.',
        'name.description' => 'Il prodotto deve avere una breve descrizione.',
        'category_id.required' => 'Devi selezionare una categoria.',
        'category_id.integer' => '\':attribute\' non ha un valore valido.'
    ];
    protected $attributeNames = [
        "name" => "nome prodotto",
        "category_id" => "categoria prodotto",
        "description" => "descrizione",
        "price" => "prezzo",
        "quantity" => "quantità",
        "imagepath" => "immagine prodotto"

    ];


    public function index()
    {
        $product = Product::available()->get();

        return view('Product.queryresult', [
            'prodlist' => $product,
            'title' => 'Tutti i prodotti',
            'tabname' => 'Tutti i prodotti'
        ]);
    }


    public function create()
    {
        if ( Auth::user()->isAdmin() ){
            return view('Product.create');
        }
        else return redirect('/');
    }


    public function store(Request $request)
    {
        if ( Auth::user()->isAdmin() ){
            //Validazione
            $validated = Validator::make(
                $request->all(),
                $this->validationRules, $this->validationMessages, $this->attributeNames
            )->validate();
            //return $validated; // validate() restituisce un array coi nomi dei campi che hanno superato la validazione

            if( ! $request->has('price')) {
                $validated['price'] = 0.0;
            }
            $validated['imagepath'] = 'dummy.png'; //teniamo sempre questa immagine generica per i nuovi prodotti
            $validated['is_disabled'] = 0;

            $product = Product::create($validated);

            return redirect('/product/'.$product->id);
        }
        return redirect('/');
    }


    public function show(Product $product)
    {
        return view('Product.show', ['product' => $product]);
    }



    public function edit(Product $product)
    {
        if ( Auth::check() && Auth::user()->isAdmin() ){
            return view('Product.edit', ['product' => $product]);
        }
        return redirect('/');
    }



    public function update(Request $request, Product $product)
    {
        if ( Auth::user()->isAdmin() ){
            //Validazione
            $updateRules = [
                "name" => "sometimes | min:3",
                "category_id" => "sometimes | numeric | min:1",
                "imagepath" => "sometimes | required",
                "description" => "sometimes | min: 5",
                "price" => "sometimes | required | min:0 | max:999999999", //sometimes + required = se c'è, non deve essere null
                "quantity" => "sometimes | max:999999999"
            ];

            $validated = Validator::make(
                $request->all(),
                $updateRules, $this->validationMessages, $this->attributeNames
            )->validate();

            //Elaborazione
            if( request('is_disabled') ) {
                //$validated['is_disabled'] = 1;
                $product->disable(); //così viene eliminato anche dai carrelli degli utenti
            }
            else {
                //$validated['is_disabled'] = 0;
                $product->enable();
            }

            $product->update($validated);

            if ($request->ajax()) return json_encode(['status' => "OK"]);
            return redirect('/product/'.$product->id);
        }
        if ($request->ajax()) return json_encode(["status" => "ERR", "statusText" => "Non sei un admin"]);
        else return redirect('/');
    }



    public function destroy(Product $product)
    {
        if ( Auth::user()->isAdmin() ) {
            $product->disable();
            return json_encode(["status" => "OK"]);
        }
        else return json_encode([
            "status" => "ERROR",
            "statusText" => "Non sei un admin",
        ]);
    }
}
