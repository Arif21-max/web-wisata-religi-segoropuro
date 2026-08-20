<?php

namespace App\Http\Controllers;

use App\Models\BarangHilang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangHilangController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));
        $status = trim((string) $request->query('status', BarangHilang::STATUS_BELUM));

        if (! in_array($status, [BarangHilang::STATUS_BELUM, BarangHilang::STATUS_SUDAH, 'Semua'], true)) {
            $status = BarangHilang::STATUS_BELUM;
        }

        $items = BarangHilang::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama_barang', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('lokasi_ditemukan', 'like', "%{$q}%");
                });
            })
            ->when($status !== 'Semua', fn ($query) => $query->where('status', $status))
            ->orderByDesc('tanggal_ditemukan')
            ->paginate(9)
            ->withQueryString();

        $jumlahBelum = BarangHilang::where('status', BarangHilang::STATUS_BELUM)->count();
        $jumlahSudah = BarangHilang::where('status', BarangHilang::STATUS_SUDAH)->count();

        return view('pages.barang-hilang', compact('items', 'q', 'status', 'jumlahBelum', 'jumlahSudah'));
    }
}
