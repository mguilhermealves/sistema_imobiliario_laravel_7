<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientsExport;

class ExportExcelController extends Controller
{
    /**
     * Export Clientes
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function export_client(Request $request)
    {
        return Excel::download(new ClientsExport, 'users.xlsx');
    }
}
