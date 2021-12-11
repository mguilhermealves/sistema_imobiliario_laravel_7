<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propertie;
use App\PropertiesImages;

class ImoveisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Propertie::all();

        return view('pages.imoveis.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.imoveis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isImage = false;

        $propertie = Propertie::create([
            'address' => $request->address,
            'number_address' => $request->address_number,
            'complement' => $request->address_complement,
            'code_postal' => $request->cep,
            'district' => $request->district,
            'city' => $request->city,
            'uf' => $request->uf,
            'type_propertie' => $request->type_propertie,
            'object_propertie' => $request->object_propertie,
            'price_location' => $request->price_location,
            'price_sale' => $request->price_sale,
            'price_iptu' => $request->price_iptu,
            'price_condominium' => $request->price_condominium,
            'deadline_contract' => $request->deadline_contract,
            'financial_propertie' => $request->financial_propertie,
            'financer_name' => $request->financer_name,
            'isswap' => $request->isswap,
            'comments' => $request->comments,
            'active' => 1
        ]);

        //quando existir a imagem na request
        if ($request->hasFile('images')) {
            for ($i=0; $i < count($request->allFiles()['images']); $i++) {
                $file = $request->allFiles()['images'][$i];

                $propertieImage = new PropertiesImages();
                $propertieImage->properties_id = $propertie->id;
                $propertieImage->url = $file->store('propertie/' . $propertie->id);
                $propertieImage->save();
            }

            $isImage = true;
        }

        if (!$isImage) {
            return redirect()->route('imoveis')->with('message', 'Imovel criado com sucesso, imagens não adicionadas na propriedade com o código N° ' . $propertie->id);
        } else {
            return redirect()->route('imoveis')->with('message', 'Imovel criado com sucesso...');
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
        $propertie = Propertie::with('images')->find($id);

        return view('pages.imoveis.show', compact('propertie'));
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
        dd($request);
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