<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangHilang;
use App\Support\UploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangHilangController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $items = BarangHilang::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama_barang', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('lokasi_ditemukan', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.barang-hilang.index', compact('items', 'q'));
    }

    public function create(): View
    {
        return view('admin.barang-hilang.form', ['item' => new BarangHilang]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $data['foto'] = $request->hasFile('foto')
            ? UploadHelper::store($request->file('foto'), 'item')
            : 'uploads/dompet.jpg';

        BarangHilang::create($data);

        return redirect()->route('admin.barang-hilang.index')->with('success', 'Barang berhasil dilaporkan.');
    }

    public function edit(BarangHilang $item): View
    {
        return view('admin.barang-hilang.form', compact('item'));
    }

    public function update(Request $request, BarangHilang $item): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            UploadHelper::delete($item->foto);
            $data['foto'] = UploadHelper::store($request->file('foto'), 'item');
        }

        $item->update($data);

        return redirect()->route('admin.barang-hilang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(BarangHilang $item): RedirectResponse
    {
        UploadHelper::delete($item->foto);
        $item->delete();

        return redirect()->route('admin.barang-hilang.index')->with('success', 'Data barang berhasil dihapus.');
    }

    public function toggle(BarangHilang $item): RedirectResponse
    {
        $item->toggleStatus();

        $pesan = $item->isSudahDiambil()
            ? "Barang \"{$item->nama_barang}\" ditandai sudah diambil."
            : "Barang \"{$item->nama_barang}\" dikembalikan ke status belum diambil.";

        return back()->with('success', $pesan);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_barang' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string'],
            'lokasi_ditemukan' => ['required', 'string', 'max:200'],
            'tanggal_ditemukan' => ['required', 'date'],
            'status' => ['required', 'in:' . implode(',', BarangHilang::STATUSES)],
            'konten_kontak' => ['required', 'string', 'max:200'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);
    }
}
