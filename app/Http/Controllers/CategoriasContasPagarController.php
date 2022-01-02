<?php

namespace App\Http\Controllers;

use App\AccountPayCategory;
use Illuminate\Http\Request;

class CategoriasContasPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = AccountPayCategory::where('active', 1)->get();

        return view('pages.contas_pagar.categorias.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.contas_pagar.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AccountPayCategory::create([
            'name_category' => $request->name_category,
            'type_category' => $request->type_category,
            'cost_center_category' => $request->cost_center_category,
            'active' => 1
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Categoria criada com sucesso.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account_category = AccountPayCategory::where('id', $id)->first();

        return view('pages.contas_pagar.categorias.show', [
            'account_category' => $account_category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
