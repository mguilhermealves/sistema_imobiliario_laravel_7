<?php

namespace App\Http\Controllers;

use App\Propertie;
use App\Tenant;
use Illuminate\Http\Request;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

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

        $propertie = Propertie::where('id', $received->propertie['propertie_id'])->first();

        $obj_propertie = '';

        if ($propertie['object_propertie'] == 'location') {
            $value_propertie = $propertie['price_location'];
            $obj_propertie = 'Locação';
        } else {
            $value_propertie = $propertie['price_sale'];
            $obj_propertie = 'Venda';
        }

        return view('pages.contas_receber.show', [
            'received' => $received,
            'value_propertie' => $value_propertie,
            'obj_propertie' => $obj_propertie
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
        $value = str_replace(array('.', ','), '', $request->amount);
        $fees = str_replace(array('.', ','), '', $request->fees);
        $fine = str_replace(array('.', ','), '', $request->fine);

        $valueFormat = intVal($value);
        $feesFormat = intVal($fees);
        $fineFormat = intVal($fine);

        if ($request->payment_method == 'ticket') {
            $clientId = 'Client_Id_8f31bad8f7b617e1dd8c3f90b004b3a8bae64ffe'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
            $clientSecret = 'Client_Secret_0c6477c6f0e9bc98d107f99a68c428c6b8f5e4ea'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

            $options = [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'sandbox' => true // altere conforme o ambiente (true = homologação e false = producao)
            ];

            $item_1 = [
                'name' => 'Referente - ' . $request->obj_propertie . ' do Imóvel pela SISMOB', // nome do item, produto ou serviço
                'amount' => 1, // quantidade
                'value' => $valueFormat // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
            ];

            $items = [
                $item_1
            ];
            //$metadata = array('notification_url' => 'sua_url_de_notificacao_.com.br'); //Url de notificações
            $customer = [
                'name' => 'Gorbadoc Oldbuck', // nome do cliente
                'cpf' => '94271564656', // cpf válido do cliente
                'phone_number' => '5144916523', // telefone do cliente
            ];
            // $discount = [ // configuração de descontos
            //     'type' => 'currency', // tipo de desconto a ser aplicado
            //     'value' => 599 // valor de desconto
            // ];
            $configurations = [ // configurações de juros e mora
                'fine' => $feesFormat, // porcentagem de multa
                'interest' => $fineFormat // porcentagem de juros
            ];
            // $conditional_discount = [ // configurações de desconto condicional
            //     'type' => 'percentage', // seleção do tipo de desconto
            //     'value' => 500, // porcentagem de desconto
            //     'until_date' => '2019-08-30' // data máxima para aplicação do desconto
            // ];
            $bankingBillet = [
                'expire_at' => $request->due_date, // data de vencimento do titulo
                'message' => 'teste\nteste\nteste\nteste', // mensagem a ser exibida no boleto
                'customer' => $customer,
            ];
            $payment = [
                'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
            ];

            $body = [
                'items' => $items,
                'payment' => $payment
            ];

            try {
                $api = new Gerencianet($options);
                $pay_charge = $api->oneStep([], $body);
                echo '<pre>';
                print_r($pay_charge);
                echo '<pre>';
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }
    }
}
