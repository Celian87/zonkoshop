<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Product\Category\create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = validate($request, [
            'name' => 'required',
        ]);

        Category::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('Product.queryresult', [
            'prodlist' => $category->products()->available()->get(),
            'title' => 'Visualizza tutti i prodotti per '.$category->name,
            'tabname' => $category->name
            ]);
    }

    public function showNotAvailable(Category $category)
    {
        if ( Auth::check() && Auth::user()->isAdmin() ){
            return view('Product.queryresult', [
                'prodlist' => $category->products()->notAvailable()->get(),
                'title' => $category->name.' non disponbili',
                'tabname' => $category->name.' non disponbili'
                ]);
            }
        else return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('Product\Category\edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }


}
