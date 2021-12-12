<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Propertie, CivilState, Genre, Tenant, TenantAddress, TenantPartner, TenantOffice, TenantFile};

class LocatariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.locatarios.index');
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
        dd($request->toArray());

        $isFiles = false;

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
            'active' => 1
        ]);

        $tenant_address = TenantAddress::create([
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

        $tenant_partner = TenantPartner::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mail' => $request->mail,
            'cpf_cnpj' => $request->cpf_cnpj,
            'rg' => $request->rg,
            'cnh' => $request->cnh,
            'tenant_id' => $tenant->id,
            'active' => 1
        ]);

        $tenant_office = TenantOffice::create([
            'type_work' => $request->type_work,
            'company_name_clt' => $request->company_name_clt,
            'company_name_pj' => $request->company_name_pj,
            'office' => $request->office,
            'registration_time' => $request->registration_time,
            'rent_monthly' => $request->rent_monthly,
            'tenant_id' => $tenant->id,
            'active' => 1
        ]);

        //VERIFICAR ANTES
        $tenant_file = TenantFile::create([
            'image_file' => $request->image_file,
            'IRPF_file' => $request->IRPF_file,
            'tenant_id' => $tenant->id,
            'active' => 1
        ]);

        //quando existir a imagem na request
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->allFiles()['images']); $i++) {
                $file = $request->allFiles()['images'][$i];

                $propertieImage = new TenantFile();
                $propertieImage->properties_id = $tenant->id;
                $propertieImage->url = $file->store('tenant/' . $tenant->id);
                $propertieImage->save();
            }

            $isImage = true;
        }

        if (!$isImage) {
            return redirect()->route('locatario')->with(['message' => 'Locatário criado com sucesso, imagens não adicionadas no locatário com o código N° ' . $tenant->id]);
        } else {
            return redirect()->route('locatario')->with(['message' => 'Locatário criado com sucesso...']);
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
