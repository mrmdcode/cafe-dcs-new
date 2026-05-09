<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerPrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printers  = Printer::where('company_id', auth()->user()->company_id)->get();
        return view('dashboard.company.manager.printers', compact('printers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'local_address' => 'required|string|max:255',
            'cashier'       => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $printer = Printer::create([
            'company_id'    => auth()->user()->company_id,
            'name'          => $request->name,
            'local_address' => $request->local_address,
            'cashier'       => $request->cashier,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'پرینتر با موفقیت ایجاد شد.',
            'printer' => $printer, // optionally return the new data to append to table via JS
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Printer $printer)
    {
        return view('dashboard.company.manager.printers', compact('printer'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Printer $printer): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'local_address' => 'required|string|max:255',
            'cashier'       => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $printer->update($request->only(['name', 'local_address', 'cashier']));

        return response()->json([
            'status'  => 'success',
            'message' => 'پرینتر با موفقیت ویرایش شد.',
            'printer' => $printer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Printer $printer)
    {
        $printer->delete();
        return $this->redirectWithStatus('success', 'پرینتر با موفقیت حذف شد.');
    }

    /**
     * Redirect to printer index with flash message.
     */
    private function redirectWithStatus(string $status, string $message): RedirectResponse
    {
        session()->flash('status', $status);
        session()->flash('message', $message);

        return redirect()->route('company.printer.index');
    }

    public function getCashierPrinter()
    {
        $printer = Printer::where('company_id', auth()->user()->company_id)
            ->where('cashier', true)
            ->first();

        return response()->json([
            'printer' => $printer ? $printer->local_address : null, // system printer name, e.g. 'EPSON TM-T88V'
        ]);
    }

    // public function downloadPrivateKey()
    // {
    //     // Path to your private key file (store it outside public/)
    //     $filePath = storage_path('app/qz-tray/private.key');
    //     if (! file_exists($filePath)) {
    //         abort(404, 'Private key not found. Please contact support.');
    //     }
    //     return response()->download($filePath, 'private.key');
    // }

    public function certificate()
    {
        $cert = file_get_contents(storage_path('app/qz-tray/certificate.pem'));
        return response($cert)->header('Content-Type', 'text/plain');
    }
}
