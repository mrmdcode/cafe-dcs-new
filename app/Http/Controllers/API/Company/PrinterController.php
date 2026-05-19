<?php
namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\JsonResponse;

class PrinterController extends Controller
{
    public function getCashierPrinter(): JsonResponse
    {
        $printer = Printer::where('company_id', auth()->user()->company_id)
            ->where('cashier', true)
            ->first();

        return response()->json([
            'printer' => $printer ? $printer->local_address : null, // system printer name, e.g. 'EPSON TM-T88V'
        ]);
    }

    public function certificate()
    {
        $cert = file_get_contents(storage_path('app/qz-tray/certificate.pem'));
        return response($cert)->header('Content-Type', 'text/plain');
    }
}
