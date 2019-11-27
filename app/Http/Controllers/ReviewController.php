<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    private $validationRules = [
        'product_id' => 'required|numeric',
        'content' => 'required | min: 15'
    ];
    private $validationMessages = [
        //Messaggi d'errore
        'product_id.required' => 'Devi specificare un :attribute',
        'content.required'  => 'Il :attribute non può essere vuoto',
        'content.min'  => 'Il :attribute deve contenere almeno :min caratteri',
        'content.max'  => 'Il :attribute è troppo lungo',
    ];
    private $attributeNames = [
        'product_id' => 'ID prodotto',
        'content' => 'testo della recensione'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request = $request->all();
        $product = \App\Product::findorfail($request['product_id']);

        return view('Review.create', ['product' => $product] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validazione
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'content' => 'required | min: 15'
        ], $this->validationMessages, $this->attributeNames
        );
        $validated = $validator->validate(); //chiamo validate() per usarne le funzionalità redirect automatico

        //Creo e salvo la nuova recensione
        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->product_id = $validated['product_id'];
        $review->content = $validated['content'];
        $review->save();

        return redirect(route('ShowProduct',$validated['product_id']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('Review.show', ['review' => $review]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        if ($review->user->id == Auth::user()->id) {
            return view('Review.edit', ['review' => $review ] );
        }
        else return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //Validazione
        $validator = Validator::make($request->all(), [
                'content' => 'required | min: 15'
            ], $this->validationMessages, $this->attributeNames);
        $validated = $validator->validate();

        if ( $review->user->id == Auth::user()->id){
            //Solo l'autore può modificare il testo
            //L'admin non può cambiare le recensioni ma può eliminarle
            $review->update(['content' => $request->content]);
            return redirect(route('ShowProduct',request('product_id')));
        }
        else return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ( Auth::user()->isAdmin() || $review->user->id == Auth::user()->id) {

            //Solo un admin o l'autore possono eliminare recensioni
            $product_id = $review->product_id;
            $review->delete();
            return redirect(route('ShowProduct',$review->product));
        }
        else return redirect()->back();
    }
}
