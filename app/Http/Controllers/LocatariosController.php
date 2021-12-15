<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Propertie, CivilState, Genre, Tenant, TenantAddress, TenantPartner, TenantOffice, TenantFile, TenantPropertie};
use Carbon\Carbon;

class LocatariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::where('active', 1)
            ->with('address', 'partner', 'office', 'files', 'propertie')
            ->get();

        return view('pages.locatarios.index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $civil_states = CivilState::where('active', 1)
            ->get();

        $genres = Genre::where('active', 1)
            ->get();

        return view('pages.locatarios.create', [
            'civil_states' => $civil_states,
            'genres' => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->is_aproved == 'approved') {
            $protocolo = Carbon::now()->format('Ymdhis');
        }

        $propertie = Propertie::where('id', $request->cod_imovel)->first();

        $tenant = Tenant::create([
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
            'is_children' => $request->is_children,
            'is_pet' => $request->is_pet,
            'pet_species' => $request->pet_species,
            'number_residents' => $request->number_residents,
            'is_aproved' => $request->is_aproved,
            'comments' => $request->comments,
            'n_contract' => $request->is_aproved == 'approved' ? $protocolo : null,
            'day_due' => $request->day_due,
            'active' => 1
        ]);

        TenantPropertie::create([
            'address' => $propertie->address,
            'number_address' => $propertie->number_address,
            'complement' => $propertie->complement,
            'code_postal' => $propertie->code_postal,
            'district' => $propertie->district,
            'city' => $propertie->city,
            'uf' => $propertie->uf,
            'type_propertie' => $propertie->type_propertie,
            'object_propertie' => $propertie->object_propertie,
            'active' => 1,
            'tenant_id' => $tenant->id,
            'propertie_id' => $propertie->id,
        ]);

        TenantAddress::create([
            'address' => $request->address,
            'number_address' => $request->address_number,
            'complement' => $request->address_complement,
            'code_postal' => $request->cep,
            'district' => $request->district,
            'city' => $request->city,
            'uf' => $request->uf,
            'active' => 1,
            'tenant_id' => $tenant->id,
        ]);

        TenantPartner::create([
            'first_name' => $request->first_name_partner,
            'last_name' => $request->last_name_partner,
            'cpf_cnpj' => $request->cpf_cnpj_partner,
            'rg' => $request->rg_partner,
            'cnh' => $request->cnh_partner,
            'tenant_id' => $tenant->id,
            'active' => 1
        ]);

        TenantOffice::create([
            'type_work' => $request->offices['type_work'],
            'company_name_clt' => $request->offices['company_name_clt'],
            'company_name_pj' => $request->offices['company_name_pj'],
            'office' => $request->offices['office'],
            'registration_time' => $request->offices['registration_time'],
            'rent_monthly' => $request->offices['rent_monthly'],
            'tenant_id' => $tenant->id,
            'active' => 1
        ]);

        //quando existir a imagem na request
        if ($request->hasFile('certification_married')) {
            $file_certification_married = $request['certification_married'];

            $tenant_certification_married = new TenantFile();
            $tenant_certification_married->tenant_id = $tenant->id;
            $tenant_certification_married->certification_married_file = $file_certification_married->store('tenant/certification_married/id/' . $tenant->id);
            $tenant_certification_married->active = 1;
            $tenant_certification_married->save();
        }

        if ($request->hasFile('offices')['image_file']) {
            for ($i = 0; $i < count(array($request->file('offices')['image_file'])); $i++) {
                $file_image_file = $request->file('offices')['image_file'][$i];

                $tenant_image_file = new TenantFile();
                $tenant_image_file->tenant_id = $tenant->id;
                $tenant_image_file->image_file = $file_image_file->store('tenant/payment_voucher/id/' . $tenant->id);
                $tenant_image_file->active = 1;
                $tenant_image_file->save();
            }
        }

        if ($request->hasFile('offices')['IRPF_file']) {
            for ($i = 0; $i < count(array($request->file('offices')['IRPF_file'])); $i++) {
                $file_IRPF_file = $request->file('offices')['IRPF_file'][$i];

                $tenant_IRPF_file = new TenantFile();
                $tenant_IRPF_file->tenant_id = $tenant->id;
                $tenant_IRPF_file->IRPF_file = $file_IRPF_file->store('tenant/IRPF_file/id/' . $tenant->id);
                $tenant_IRPF_file->active = 1;
                $tenant_IRPF_file->save();
            }
        }

        return response()->json([
            'sucesso' => true,
            'message' => 'Locatário criado com sucesso...'
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
     * autocomplete properties
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Propertie::where('id', $request->cod_propertie)
            ->select('address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'type_propertie', 'object_propertie')
            ->first();

        return response()->json($data);
    }
}
