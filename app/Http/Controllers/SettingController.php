<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    public function index()
    {
        $groups = Setting::select('group')->distinct()->pluck('group');
        $settings = [];
        
        foreach ($groups as $group) {
            $settings[$group] = Setting::where('group', $group)->get();
        }

        return view('settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'required'
        ]);

        foreach ($request->settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function getSkckSettings()
    {
        return [
            'expiry_months' => Setting::getValue('skck_expiry_months', 6),
            'issue_fee' => Setting::getValue('skck_issue_fee', 30000),
            'legalize_fee' => Setting::getValue('skck_legalize_fee', 5000),
            'company_name' => Setting::getValue('company_name', 'POLSEK GUNUNG PUTRI'),
            'company_address' => Setting::getValue('company_address', 'Jl. Mercedes Benz, RT.01/RW.10, Cicadas, Kec. Gn. Putri, Kabupaten Bogor, Jawa Barat 16830'),
            'start_number_skck' => Setting::getValue('start_number_skck', 1),
            'daily_limit' => Setting::getValue('daily_limit', 100),
            'company_phone' => Setting::getValue('company_phone', '(021) 8671405'),
        ];
    }
}