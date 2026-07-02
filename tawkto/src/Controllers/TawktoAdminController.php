<?php

namespace App\Addons\Tawkto\Controllers;

use App\Models\Admin\Setting;
use Illuminate\Http\Request;

class TawktoAdminController
{
    public function showSettings()
    {
        return view('tawkto_admin::settings');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'tawkto_widget_code' => 'required|string',
        ]);

        Setting::updateSettings($validated);

        return back()->with('success', __('tawkto::messages.admin.settings.saved'));
    }
}
