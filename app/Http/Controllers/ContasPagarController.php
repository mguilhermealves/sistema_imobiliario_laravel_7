<?php

namespace App\Http\Controllers;

use App\AccountPay;
use App\AccountPayCategory;
use Illuminate\Http\Request;

class ContasPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_pays = AccountPay::with('category', 'method_payment')->where('active', 1)->get();

        return view('pages.contas_pagar.index', [
            'account_pays' => $account_pays
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.contas_pagar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $continue = false;

        $account_category = AccountPayCategory::where('id', $request->center_count)->first();

        if (!empty($account_category) && $account_category->count() > 0) {
            $continue = true;
        } else {
            $continue = false;
        }

        $amount = str_replace(',', '.', $request->amount);

        if ($continue) {
            AccountPay::create([
                'company_beneficiary' => $request->company_beneficiary,
                'amount' => $amount,
                'is_recorrency' => $request->is_recorrency,
                'day_due' => $request->day_due,
                'payment_method' => $request->payment_method,
                'comments' => $request->comments,
                'account_category_id' => $account_category->id,
                'active' => 1
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Conta Cadastrada com sucesso.'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Ocorreu um erro ao Cadastrar a conta.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Create Account payments
     *
     * @return \Illuminate\Http\Response
     */
    public function createAccountPays()
    {
        return view('pages.contas_pagar.create');
    }

    /**
     * autocomplete properties
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = AccountPayCategory::where('id', $request->cod_propertie)
            ->select('name_category', 'type_category', 'cost_center_category')
            ->first();

        return response()->json($data);
    }
}
