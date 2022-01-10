<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{ClientsExport, PropertiesExport, TenantsExport};

class ExportExcelController extends Controller
{
    /**
     * Export Clientes
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function export_client(Request $request)
    {
        return Excel::download(new ClientsExport, 'relatorios-clientes.xlsx');
    }

    /**
     * Export Propriedades
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function export_propertie(Request $request)
    {
        return Excel::download(new PropertiesExport, 'relatorios-imoveis.xlsx');
    }

    /**
     * Export Locatarios
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function export_tenants(Request $request)
    {
        return Excel::download(new TenantsExport, 'relatorios-locatarios.xlsx');
    }
}
