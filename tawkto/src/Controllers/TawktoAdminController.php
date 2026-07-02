<?php

namespace App\Addons\Tawkto\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::table('settings')->updateOrInsert(
            ['key' => 'tawkto_widget_id'],
            ['value' => $validated['tawkto_widget_id']]
        );

        return redirect()->back()->with('success', __('tawkto::messages.admin.settings.saved'));
    }
}
