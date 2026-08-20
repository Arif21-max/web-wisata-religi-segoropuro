<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Support\UploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KontakController extends Controller
{
    public function edit(): View
    {
        return view('admin.kontak.edit', ['kontak' => kontak() ?? new Kontak]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'alamat' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:30'],
            'whatsapp_default_message' => ['nullable', 'string', 'max:500'],
            'google_maps_embed' => ['nullable', 'string', 'max:2000'],
            'gambar_hero' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'gambar_sejarah' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $embed = sanitize_maps_embed($request->input('google_maps_embed'));

        if ($request->filled('google_maps_embed') && $embed === null) {
            return back()
                ->withErrors(['google_maps_embed' => 'Kode embed Google Maps tidak valid. Gunakan tautan/iframe dari google.com/maps dengan protokol https.'])
                ->withInput();
        }

        $data['google_maps_embed'] = $embed;

        $kontak = kontak();

        if (! $kontak) {
            $kontak = new Kontak;
        }

        foreach (['gambar_hero', 'gambar_sejarah'] as $field) {
            if ($request->boolean('hapus_' . $field)) {
                UploadHelper::delete($kontak->{$field});
                $data[$field] = null;

                continue;
            }

            if ($request->hasFile($field)) {
                UploadHelper::delete($kontak->{$field});
                $data[$field] = UploadHelper::store($request->file($field), str_replace('gambar_', '', $field));

                continue;
            }

            unset($data[$field]);
        }

        $kontak->fill($data)->save();

        return redirect()->route('admin.kontak.edit')->with('success', 'Kontak berhasil diperbarui.');
    }
}
