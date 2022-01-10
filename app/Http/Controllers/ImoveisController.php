<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propertie;
use App\PropertiesClients;
use App\PropertiesImages;
use App\Client;
use App\Http\Requests\CreatedOrUpdatedPropertieRequest;
use App\ObjectivePropertie;
use App\TypePropertie;
use Illuminate\Support\Str;

class ImoveisController extends Controller
{

    private $propertie, $totalPage = 10;
    private $path = 'propertie/';

    public function __construct(Propertie $propertie)
    {
        $this->propertie = $propertie;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = $this->propertie->filters();

        return view('pages.imoveis.index', [
            'properties' => $properties
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_propertie = TypePropertie::where('active', 1)->get();
        $objective_properties = ObjectivePropertie::where('active', 1)->get();
        return view('pages.imoveis.create', [
            'type_propertie' => $type_propertie,
            'objective_properties' => $objective_properties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatedOrUpdatedPropertieRequest $request)
    {
        if (!$request->cod_client) {
            return response()->json([
                'error' => true,
                'message' => 'O cliente não foi selecionado'
            ]);
        }

        $client = Client::where('id', $request->cod_client)->first();

        $propertie = Propertie::create([
            'address' => $client['address'],
            'number_address' => $client['number_address'],
            'complement' => $client['complement'],
            'code_postal' => $client['code_postal'],
            'district' => $client['district'],
            'city' => $client['city'],
            'uf' => $client['uf'],
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
            'client_propertie_id' => $request->cod_client,
            'active' => 1
        ]);

        //quando existir a imagem na request
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->allFiles()['images']); $i++) {
                $file = $request->allFiles()['images'][$i];

                $fileName = $file->getClientOriginalName();
                $url = $file->store($this->path . $propertie->id);

                PropertiesImages::create([
                    'name' => $fileName,
                    'url' => $url,
                    'properties_id' => $propertie->id
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Imovel criado com sucesso...'
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
        $propertie = Propertie::with('images', 'client_properties')->find($id);

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
    public function update(CreatedOrUpdatedPropertieRequest $request, $id)
    {
        $type_propertie = TypePropertie::where('name', $request->type_propertie)->first();
        $objective_propertie = ObjectivePropertie::where('slug', $request->object_propertie)->first();

        $propertie = Propertie::with('images')->find($id);

        if ($objective_propertie['slug'] == 'sale') {
            $propertie['price_location'] = null;
            $propertie['price_sale'] = $request['price_sale'];
        } else {
            $propertie['price_sale'] = null;
            $propertie['price_location'] = $request['price_location'];
        }

        $client = Client::where('id', $request->cod_client)->first();

        $propertie['address'] = $client['address'];
        $propertie['number_address'] = $client['number_address'];
        $propertie['complement'] = $client['complement'];
        $propertie['code_postal'] = $client['code_postal'];
        $propertie['district'] = $client['district'];
        $propertie['city'] = $client['city'];
        $propertie['uf'] = $client['uf'];
        $propertie['type_propertie'] = $type_propertie['slug'];
        $propertie['object_propertie'] = $objective_propertie['slug'];
        $propertie['deadline_contract'] = $request['deadline_contract'];
        $propertie['financial_propertie'] = $request['financial_propertie'];
        $propertie['financer_name'] = $request['financer_name'];
        $propertie['price_condominium'] = $request['price_condominium'];
        $propertie['price_iptu'] = $request['price_iptu'];
        $propertie['isswap'] = $request['isswap'];
        $propertie['comments'] = $request['comments'];

        //quando existir a imagem na request
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->allFiles()['images']); $i++) {
                $file = $request->allFiles()['images'][$i];

                $fileName = $file->getClientOriginalName();
                $url = $file->store($this->path . $propertie->id);

                PropertiesImages::create([
                    'name' => $fileName,
                    'url' => $url,
                    'properties_id' => $propertie->id
                ]);
            }
        }

        $propertie->save();

        return response()->json([
            'error' => false,
            'message' => 'Imovel editado com sucesso'
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

    /**
     * autocomplete properties
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Client::where('id', $request->cod_client)
            ->select('address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf')
            ->first();

        return response()->json($data);
    }
}
