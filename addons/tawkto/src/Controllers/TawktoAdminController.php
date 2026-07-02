<?php

namespace App\Addons\Tawkto\Controllers;

use App\Models\Admin\Setting;
use Illuminate\Http\Request;

class TawktoAdminController
{
    public function showSettings()
    {
        return view('tawkto::admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'tawkto_chat_url' => 'nullable|url|regex:/^https:\/\/tawk\.to\/chat\/[a-z0-9]+\/[a-z0-9]+$/i',
        ]);

        Setting::updateSettings($validated);

        return back()->with('success', __('tawkto::messages.admin.settings.saved'));
    }
}
