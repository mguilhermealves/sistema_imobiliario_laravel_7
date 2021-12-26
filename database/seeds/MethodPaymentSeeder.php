<?php

use App\MethodPayment;
use Illuminate\Database\Seeder;

class MethodPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods_payment = [
            ['Débito em conta', 'debit', 1],
            ['Boleto', 'ticket', 1],
            ['Transferência', 'transfer', 1],
            ['PIX', 'pix', 1],
            ['Cheque', 'cheque', 1],
            ['Outros', 'others', 1],
        ];

        foreach ($methods_payment as $method_payment) {
            MethodPayment::create([
                'name' => $method_payment[0],
                'slug' => $method_payment[1],
                'active' => $method_payment[2],
            ]);
        }
    }
}
