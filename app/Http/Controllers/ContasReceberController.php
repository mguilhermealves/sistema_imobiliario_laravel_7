<?php

namespace App\Http\Controllers;

use App\AccountReceivable;
use App\AccountReceivableBankSlip;
use App\Jobs\newAccountReceivable as JobsNewAccountReceivable;
use App\Jobs\ResendTicket;
use App\Propertie;
use App\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

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
        $received = Tenant::with('address', 'partner', 'office', 'files', 'propertie', 'propertie.objetivie_properties', 'propertie.type_properties', 'contract')->where('id', $id)->first();

        $payments = AccountReceivable::with('historic_bank', 'method_payment')->where('tenant_id', $received['id'])->get();

        $propertie = Propertie::where('id', $received->propertie['propertie_id'])->first();

        $obj_propertie = '';

        if ($propertie['object_propertie'] == 'location') {
            $value_propertie = $propertie['price_location'];
            $obj_propertie = 'Loca????o';
        } else {
            $value_propertie = $propertie['price_sale'];
            $obj_propertie = 'Venda';
        }

        return view('pages.contas_receber.show', [
            'received' => $received,
            'payments' => $payments,
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
        $payment = AccountReceivable::with('historic_bank')->find($id);

        $status_payment = '';
        if ($payment['status_payment'] == 'waiting') {
            $status_payment = 'Aguardando Pagamento';
        } elseif ($payment['status_payment'] == 'paid') {
            $status_payment = 'Pago';
        } else {
            $status_payment = 'N??o Pago';
        }

        $dtNow = now();

        $dias_em_atraso = '';
        if ($payment->historic_bank['expire_at'] >= $dtNow) {
            $dias_em_atraso = 0;
        } else {
            $dias_em_atraso = $dtNow->diff($payment->historic_bank['expire_at']);
        }

        $day_due = date("d", strtotime($payment['day_due']));

        $json_historical_bank = json_decode($payment->historic_bank->historic_bank);

        return view('pages.contas_receber.show_payment', [
            'payment' => $payment,
            'json_historical_bank' => $json_historical_bank,
            'dias_em_atraso' => $dias_em_atraso,
            'status_payment' => $status_payment,
            'day_due' => $day_due
        ]);
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
        if ($request->payment_method == null) {
            return response()->json([
                'error' => true,
                'message' => 'O campo m??todo de pagamento ?? obrigat??rio.'
            ]);
        }

        $str = str_replace('.', '', $request->amount); // remove o ponto
        $value = str_replace(',', '.', $str);
        $fees = intVal(preg_replace('/[^0-9]/', '', $request->fees));
        $fine = intVal(preg_replace('/[^0-9]/', '', $request->fine));
        $due_date = Carbon::now()->format('Y-m-') . $request->due_day;

        $tenant = Tenant::where('id', $id)->first();

        $document_tenant = preg_replace('/[^0-9]/', '', $tenant->cpf_cnpj);
        $cel_phone_tenant = preg_replace('/[^0-9]/', '', $tenant->celphone);

        DB::beginTransaction();

        try {
            $account_receivable = AccountReceivable::create([
                'description' => $request->description,
                'status_payment' => 'waiting',
                'day_due' => $due_date,
                'fees' => $fees,
                'fine' => $fine,
                'amount' => $value,
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
                    'sandbox' => true // altere conforme o ambiente (true = homologa????o e false = producao)
                ];

                $item_1 = [
                    'name' => 'Referente - ' . $request->obj_propertie . ' do Im??vel pela SISMOB', // nome do item, produto ou servi??o
                    'amount' => 1, // quantidade
                    'value' => intVal(str_replace('.', '', $value)) // valor (1000 = R$ 10,00) (Obs: ?? poss??vel a cria????o de itens com valores negativos. Por??m, o valor total da fatura deve ser superior ao valor m??nimo para gera????o de transa????es.)
                ];

                $items = [
                    $item_1
                ];
                //$metadata = array('notification_url' => 'sua_url_de_notificacao_.com.br'); //Url de notifica????es
                $customer = [
                    'name' => $tenant['first_name'] . ' ' . $tenant['last_name'], // nome do cliente
                    'cpf' => $document_tenant, // cpf v??lido do cliente
                    'phone_number' => $cel_phone_tenant, // telefone do cliente
                    'email' => $tenant['mail']
                ];

                $configurations = [ // configura????es de juros e mora
                    'fine' => intVal(str_replace('.', '', $fine)), // porcentagem de multa
                    'interest' => intVal(str_replace('.', '', $fees)) // porcentagem de juros
                ];

                $bankingBillet = [
                    'expire_at' => $due_date, // data de vencimento do titulo
                    'message' => '', // mensagem a ser exibida no boleto
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
                } catch (GerencianetException $e) {
                    print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            } else {
                AccountReceivableBankSlip::create([
                    'barcode' => null,
                    'link' => null,
                    'pdf' => null,
                    'expire_at' => null,
                    'charge_id' => null,
                    'status' => null,
                    'total' => null,
                    'payment' => null,
                    'account_receivables_id' => $account_receivable->id,
                    'active' => 1
                ]);
            }

            DB::commit();

            JobsNewAccountReceivable::dispatch($tenant)->delay(now()->addSeconds('5'));

            return response()->json([
                'error' => false,
                'message' => 'Pagamento criado com sucesso...'
            ]);
        } catch (\Exception  $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => 'Erro ao processar o pagamento, refa??a o processo...'
            ]);
        }
    }

    /**
     * Editar Dados do Pagamento
     *
     * @param \Illuminate\Http\Request  $request
     *
     */
    public function payment_edit(Request $request)
    {
        $due_date = Carbon::now()->format('Y-m-') . $request->day_due;

        $dtNow = now();

        $diff_date = $dtNow->diff($due_date);

        if ($diff_date->invert == 1) {
            return response()->json([
                'error' => true,
                'message' => 'A nova data de vencimento deve ser pelo menos maior que a data atual.'
            ]);
        }

        $payment = AccountReceivable::with('historic_bank')->where('id', $request->id)->first();

        if ($payment['payment_method'] == 'ticket') {
            if ($payment->historic_bank->expire_at <= $due_date) {
                $clientId = env('CLIENTID'); // insira seu Client_Id, conforme o ambiente (Des ou Prod)
                $clientSecret = env('CLIENTSECRET'); // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

                $options = [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'sandbox' => true // altere conforme o ambiente (true = Homologa????o e false = producao)
                ];

                // $charge_id refere-se ao ID da transa????o gerada anteriormente
                $params = [
                    'id' => $payment->historic_bank['charge_id']
                ];

                $body = [
                    'expire_at' => $due_date
                ];

                try {
                    $api = new Gerencianet($options);
                    $charge = $api->updateBillet($params, $body);

                    AccountReceivableBankSlip::where('charge_id', $payment->historic_bank['charge_id'])
                        ->update([
                            'expire_at' => $due_date,
                            'status' => 'waiting',
                        ]);

                    return response()->json([
                        'error' => false,
                        'message' => 'O vencimento para esse pagamento foi atualizado com sucesso.'
                    ]);
                } catch (GerencianetException $e) {
                    print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Boleto vencido, n??o ?? possivel alterar a data de pagamento.'
                ]);
            }
        } else {
            $payment['day_due'] = $due_date;
            $payment['status_payment'] = $request->status;
            $payment->save();

            AccountReceivableBankSlip::where('account_receivables_id', $payment->id)
                ->update([
                    'expire_at' => $due_date,
                    'status' => $request->status,
                ]);

            return response()->json([
                'error' => false,
                'message' => 'Pagamento atualizado com sucesso.'
            ]);
        }
    }

    /**
     * Consultar Boletos CRON
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function consult_payment_slip()
    {
        //Procura somento os boletos que estao com o status "Aguardando Pagamento"
        $payments = AccountReceivableBankSlip::where('payment_method', 'ticket')->where('status', 'waiting')->get();

        foreach ($payments as $payment) {
            $clientId = env('CLIENTID'); // insira seu Client_Id, conforme o ambiente (Des ou Prod)
            $clientSecret = env('CLIENTSECRET'); // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

            $options = [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'sandbox' => true // altere conforme o ambiente (true = Homologa????o e false = producao)
            ];

            $params = [
                'id' => $payment->charge_id // $charge_id refere-se ao ID da transa????o ("charge_id")
            ];

            try {
                $api = new Gerencianet($options);
                $charge = $api->detailCharge($params, []);

                $acount_payment = AccountReceivable::where('id', $payment->account_receivables_id)->first();

                $acount_payment->update([
                    'status_payment' => $charge['data']['status']
                ]);

                $historic_bank = array(
                    $charge['data']['history']
                );

                $payment->update([
                    'historic_bank' => $historic_bank,
                    'status' => $charge['data']['status']
                ]);


                print_r($charge);
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }
    }

    /**
     * Envio do boleto por email
     *
     * @param \Illuminate\Http\Request  $request
     *
     */
    public function sendEmail(Request $request)
    {
        $tenant = Tenant::where('id', $request->id)->first();

        $payment = AccountReceivable::where('id', $request->payment_id)->with('historic_bank')->first();

        ResendTicket::dispatch($tenant, $payment)->delay(now()->addSeconds('5'));

        return response()->json([
            'error' => false,
            'message' => 'E-mail enviado com sucesso'
        ]);
    }
}
