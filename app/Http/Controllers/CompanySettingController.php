<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function edit()
    {
        return view('settings.company', [
            'settings' => config('company'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'penerima' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'stempel' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        foreach (['name', 'address', 'phone', 'email', 'penerima'] as $key) {
            CompanySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key] ?? '']
            );
        }

        foreach (['logo', 'stempel'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $extension = $request->file($imageKey)->extension();
                $filename = $imageKey . '.' . $extension;
                $request->file($imageKey)->move(public_path('images'), $filename);
                CompanySetting::updateOrCreate(
                    ['key' => $imageKey],
                    ['value' => 'images/' . $filename]
                );
            }
        }

        return redirect()
            ->route('settings.company.edit')
            ->with('success', 'Pengaturan kwitansi berhasil disimpan.');
    }
}
