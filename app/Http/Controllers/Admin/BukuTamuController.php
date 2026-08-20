<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuTamuController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $ulasan = BukuTamu::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('asal_kota', 'like', "%{$q}%")
                        ->orWhere('pesan_doa', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.buku-tamu.index', compact('ulasan', 'q'));
    }

    public function destroy(BukuTamu $ulasan): RedirectResponse
    {
        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
