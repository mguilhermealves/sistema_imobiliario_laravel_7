<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\ClientPartner;
use App\ClientPartnerFile;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('pages.clientes.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isCertification = false;

        $client = Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mail' => $request->mail,
            'cpf_cnpj' => $request->cpf_cnpj,
            'rg' => $request->rg,
            'cnh' => $request->cnh,
            'phone' => $request->phone,
            'celphone' => $request->celphone,
            'genre' => $request->genre,
            'marital_status' => $request->marital_status,
            'address' => $request->address,
            'number_address' => $request->address_number,
            'complement' => $request->address_complement,
            'code_postal' => $request->cep,
            'district' => $request->district,
            'city' => $request->city,
            'uf' => $request->uf,
            'active' => 1
        ]);

        if ($request->marital_status == "married") {
            $clientPartner = ClientPartner::create([
                'first_name_partner' => $request->first_name_partner,
                'last_name_partner' => $request->last_name_partner,
                'cpf_cnpj_partner' => $request->cpf_cnpj_partner,
                'rg_partner' => $request->rg_partner,
                'cnh_partner' => $request->cnh_partner,
                'clients_id' => $request->client->id,
                'active' => 1
            ]);

            //quando existir a certidao de casamento na request
            if ($request->hasFile('certification_married')) {
                $file = $request['certification_married'];

                $clientPartnerCertification = new ClientPartnerFile();
                $clientPartnerCertification->clients_partners_id = $clientPartner->id;
                $clientPartnerCertification->url = $file->store('client/partner/file' . $client->id);
                $clientPartnerCertification->save();

                $isCertification = true;
            }
        }

        if (!$isCertification) {
            return redirect()->route('clientes')->with('message', 'Cliente criado com sucesso, a certidão de casamento não foi adicionada no cliente com o código N° ' . $client->id);
        } else {
            return redirect()->route('clientes')->with('message', 'Cliente criado com sucesso...');
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
        $client = Client::with([
            'partner', 'partner.file'
        ])->find($id);

        return view('pages.clientes.show', compact('client'));
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
