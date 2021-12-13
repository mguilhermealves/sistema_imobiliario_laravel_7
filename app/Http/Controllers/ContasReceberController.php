<?php

namespace App\Http\Controllers;

use App\Tenant;
use Illuminate\Http\Request;

class ContasReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::where('active', 1)
            ->where('is_aproved', 'approved')
            ->with('address', 'partner', 'office', 'files', 'propertie')
            ->get();

        return view('pages.contas_receber.index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $received = Tenant::with('address', 'partner', 'office', 'files', 'propertie')->find($id);

        return view('pages.contas_receber.show', [
            'received' => $received
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

    /**
     * New payment for tenants.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function new_payment($id)
    {
        $received = Tenant::with('address', 'partner', 'office', 'files', 'propertie')->find($id);

        //dd($received);

        return view('pages.contas_receber.new_payment', [
            'received' => $received
        ]);
    }

    /**
     * Payment for tenants.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        dd($request->toArray());
    }
}
