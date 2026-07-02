<?php

namespace App\Addons\Tawkto\Controllers;

use App\Models\Admin\Settings;
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
            'tawkto_widget_id' => 'required|string|max:100',
        ]);

        Settings::updateSettings($validated);

        return redirect()->back()->with('success', __('tawkto::messages.admin.settings.saved'));
    }
}
