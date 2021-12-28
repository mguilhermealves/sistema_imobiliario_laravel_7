<?php

namespace App\Exports;

use App\Tenant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TenantsExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tenant::with('address', 'partner', 'office', 'files', 'propertie', 'status')->select('id', 'first_name', 'last_name', 'mail', 'cpf_cnpj', 'genre', 'marital_status', 'is_children', 'is_pet','pet_species', 'number_residents', 'is_aproved', 'comments', 'n_contract', 'day_due', 'active')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome',
            'Sobrenome',
            'E-mail',
            'CPF / CNPJ',
            'Genero',
            'Estado Civil',
            'Tem Filhos',
            'Tem Animais',
            'Espécie',
            'Numero de Residentes',
            'Status da Aprovação',
            'Numero de Contrato',
            'Dia de Vencimento',
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
        ];
    }
}
