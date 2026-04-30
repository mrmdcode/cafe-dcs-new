<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\TemplateData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManagerTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $template = TemplateData::where('company_id', Auth::user()->company_id)->firstOrFail();
        return view('dashboard.company.manager.template', compact('template'));
    }

    public function saveTemplate(Request $request)
    {
        $validated = $request->validate([
            'address'     => 'nullable|string|max:500',
            'icon'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'       => 'nullable|string|max:255',
            'name'        => 'nullable|string|max:255',
            'slider_t'    => 'nullable|string|max:255',
            'slider_d'    => 'nullable|string',
            'sec_1_t'     => 'nullable|string|max:255',
            'sec_1_m'     => 'nullable|string|max:255',
            'sec_1_d'     => 'nullable|string',
            'sec_2_p_1_t' => 'nullable|string|max:255',
            'sec_2_p_2_t' => 'nullable|string|max:255',
            'sec_2_p_3_t' => 'nullable|string|max:255',
            'sec_2_p_1_d' => 'nullable|string',
            'sec_2_p_2_d' => 'nullable|string',
            'sec_2_p_3_d' => 'nullable|string',
            'sec_3_t'     => 'nullable|string|max:255',
            'sec_3_m'     => 'nullable|string|max:255',
            'sec_4_t'     => 'nullable|string|max:255',
            'sec_4_m'     => 'nullable|string|max:255',
            'sec_5_t'     => 'nullable|string|max:255',
            'sec_5_m'     => 'nullable|string|max:255',
            'sec_5_d'     => 'nullable|string',
            's_1_i'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            's_2_i'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            's_3_i'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            's_4_i'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            's_5_i'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $companyId = Auth::user()->company_id;
        $template  = TemplateData::where('company_id', $companyId)->first();

        $fileFields = ['icon', 's_1_i', 's_2_i', 's_3_i', 's_4_i', 's_5_i'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists and it's an update
                if ($template && $template->$field) {
                    Storage::disk('public')->delete($template->$field);
                }
                $path              = $request->file($field)->store('template-data', 'public');
                $validated[$field] = $path;
            }
        }

        TemplateData::updateOrCreate(
            ['company_id' => $companyId], // Search condition
            $validated                    // Values to set/update
        );

        return redirect()->route('company.template')->with('success', 'داده‌های قالب با موفقیت ذخیره شد.');
    }
}
