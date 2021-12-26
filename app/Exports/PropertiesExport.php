<?php

namespace App\Exports;

use App\Propertie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PropertiesExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Propertie::with('client_properties')->select('id', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'type_propertie', 'object_propertie', 'deadline_contract', 'financial_propertie', 'financer_name', 'price_condominium', 'price_location', 'price_sale', 'price_iptu', 'isswap', 'active')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Endereço',
            'N°',
            'Complemento',
            'CEP',
            'Bairro',
            'Cidade',
            'UF',
            'Tipo de Propriedade',
            'Objetivo de Propriedade',
            'Prazo do Contrato',
            'Aceita Financiamento',
            'Nome do Fiador',
            'Preço do Condominio',
            'Preço da Locação',
            'Preço da Venda',
            'Preço do IPTU',
            'Aceita Troca',
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
