<?php

namespace App\Http\Controllers;

use App\CivilState;
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
                'clients_id' => $client->id,
                'active' => 1
            ]);

            //quando existir a certidao de casamento na request
            if ($request->hasFile('certification_married')) {
                $file = $request['certification_married'];

                $clientPartnerCertification = new ClientPartnerFile();
                $clientPartnerCertification->clients_partners_id = $clientPartner->id;
                $clientPartnerCertification->url = $file->store('client/partner/file/' . $client->id);
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
            'partner', 'partner.file' => function ($query) {
                $query->orderBy('id', 'desc');
            }
        ])->find($id);

        $civil_states = CivilState::where('active', 1);

        return view('pages.clientes.show', [
            'client' => $client,
            'civil_states' => $civil_states
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
        $cpf_cnpj_formated = preg_replace('/[^0-9]/', '', $request->cpf_cnpj);
        $phone_formated = preg_replace('/[^0-9]/', '', $request->phone);
        $celphone_formated = preg_replace('/[^0-9]/', '', $request->celphone);
        $cep_formated = preg_replace('/[^0-9]/', '', $request->cep);
        $cpf_cnpj_partner_formated = preg_replace('/[^0-9]/', '', $request->cpf_cnpj_partner);

        $client = Client::with('partner')->find($id);

        $client['first_name'] = $request['first_name'];
        $client['last_name'] = $request['last_name'];
        $client['cpf_cnpj'] = $cpf_cnpj_formated;
        $client['rg'] = $request['rg'];
        $client['cnh'] = $request['cnh'];
        $client['mail'] = $request['mail'];
        $client['genre'] = $request['genre'];
        $client['marital_status'] = $request['marital_status'];
        $client['phone'] = $phone_formated;
        $client['celphone'] = $celphone_formated;
        $client['code_postal'] = $cep_formated;
        $client['address'] = $request['address'];
        $client['number_address'] = $request['address_number'];
        $client['complement'] = $request['address_complement'];
        $client['district'] = $request['district'];
        $client['city'] = $request['city'];
        $client['uf'] = $request['uf'];

        if ($request['marital_status'] == "married") {
            $client->partner['first_name_partner'] = $request['first_name_partner'];
            $client->partner['last_name_partner'] = $request['last_name_partner'];
            $client->partner['cpf_cnpj_partner'] = $cpf_cnpj_partner_formated;
            $client->partner['rg_partner'] = $request['rg_partner'];
            $client->partner['cnh_partner'] = $request['cnh_partner'];

            if ($request['certification_married']) {
                $file = $request['certification_married'];

                $url = $file->store('client/partner/file/' . $client->id);

                ClientPartnerFile::create([
                    'url' => $url,
                    'clients_partners_id' => $client->partner['id']
                ]);
            }
        }

        $client->save();
        $client->partner->save();

        return response()->json([
            'error' => false,
            'message' => 'Cliente editado com sucesso...'
        ]);
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
