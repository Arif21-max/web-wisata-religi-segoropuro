<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuTamuController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $ulasanSemua = BukuTamu::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('asal_kota', 'like', "%{$q}%")
                        ->orWhere('pesan_doa', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $ulasanTerbaru = BukuTamu::orderByDesc('id')->limit(10)->get();

        return view('pages.buku-tamu', compact('ulasanSemua', 'ulasanTerbaru', 'q'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'asal_kota' => ['required', 'string', 'max:100'],
            'pesan_doa' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        BukuTamu::create([
            'nama' => trim($request->nama),
            'asal_kota' => trim($request->asal_kota),
            'pesan_doa' => trim($request->pesan_doa),
        ]);

        return back()->with('success', 'Terima kasih, doa & pesan Anda berhasil terkirim.');
    }
}
