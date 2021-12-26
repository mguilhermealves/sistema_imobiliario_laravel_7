<?php

namespace App\Exports;

use App\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ClientsExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::select('id', 'first_name', 'last_name', 'mail', 'cpf_cnpj', 'rg', 'cnh', 'phone', 'celphone', 'genre', 'marital_status', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'active')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome',
            'Sobrenome',
            'E-mail',
            'CPF/CNPJ',
            'RG',
            'CNH',
            'Telefone',
            'Celular',
            'Genero',
            'Estado Civil',
            'Endereco',
            'Numero',
            'Complemento',
            'CEP',
            'Bairro',
            'Cidade',
            'UF',
            'Ativo'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 20,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 20,
            'S' => 10,
        ];
    }
}
