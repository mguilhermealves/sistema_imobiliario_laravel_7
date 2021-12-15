<?php

namespace App\Http\Controllers;

use App\AccountReceivable;
use App\AccountReceivableBankSlip;
use App\Propertie;
use App\Tenant;
use Carbon\Carbon;
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
        $received = Tenant::with('address', 'partner', 'office', 'files', 'propertie', 'payments')->find($id);

        // dd($received->payments);

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

        return view('pages.contas_receber.new_payment', [
            'received' => $received
        ]);
    }

    /**
     * Payment for tenants.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request, $id)
    {
        $value = str_replace(array('.', ','), '', $request->amount);
        $fees = str_replace(array('.', ','), '', $request->fees);
        $fine = str_replace(array('.', ','), '', $request->fine);
        $due_date = Carbon::now()->format('Y-m-') . $request->due_day;

        $valueFormat = intVal($value);
        $feesFormat = intVal($fees);
        $fineFormat = intVal($fine);

        $account_receivable = AccountReceivable::create([
            'description' => $request->description,
            'status_payment' => $request->status_payment,
            'day_due' => $request->day_due,
            'fees' => $request->fees,
            'fine' => $request->fine,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'tenant_id' => $id,
            'active' => 1
        ]);

        //GERENCIANET - BOLETO
        if ($request->payment_method == 'ticket') {
            $clientId = env('CLIENTID'); // insira seu Client_Id, conforme o ambiente (Des ou Prod)
            $clientSecret = env('CLIENTSECRET'); // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

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
                'email' => 'teste@teste.com.br'
            ];

            $configurations = [ // configurações de juros e mora
                'fine' => $feesFormat, // porcentagem de multa
                'interest' => $fineFormat // porcentagem de juros
            ];

            $bankingBillet = [
                'expire_at' => $due_date, // data de vencimento do titulo
                'message' => 'teste\nteste\nteste\nteste', // mensagem a ser exibida no boleto
                'customer' => $customer,
                'configurations' => $configurations
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

                AccountReceivableBankSlip::create([
                    'barcode' => $pay_charge['data']['barcode'],
                    'link' => $pay_charge['data']['link'],
                    'pdf' => $pay_charge['data']['pdf']['charge'],
                    'expire_at' => $pay_charge['data']['expire_at'],
                    'charge_id' => $pay_charge['data']['charge_id'],
                    'status' => $pay_charge['data']['status'],
                    'total' => $pay_charge['data']['total'],
                    'payment' => $pay_charge['data']['payment'],
                    'account_receivables_id' => $account_receivable->id,
                    'active' => 1
                ]);

                return redirect()->route('contas_receber')->with(['message' => 'Pagamento criado com sucesso...']);
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
