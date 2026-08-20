<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpotWisata;
use App\Support\UploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SpotWisataController extends Controller
{
    public function index(): View
    {
        $spots = SpotWisata::orderByDesc('id')->paginate(10);

        return view('admin.spot.index', compact('spots'));
    }

    public function create(): View
    {
        return view('admin.spot.form', ['spot' => new SpotWisata]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_spot' => ['required', 'string', 'max:150'],
            'deskripsi_singkat' => ['required', 'string', 'max:300'],
            'deskripsi_lengkap' => ['required', 'string'],
            'warna_bg' => ['required', 'regex:/^#[0-9a-fA-F]{3,8}$/'],
            'fotos' => ['nullable', 'array'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $data['foto'] = implode(',', $this->storePhotos($request->file('fotos', [])));
        unset($data['fotos']);

        SpotWisata::create($data);

        return redirect()->route('admin.spot-wisata.index')->with('success', 'Spot wisata berhasil ditambahkan.');
    }

    public function edit(SpotWisata $spot): View
    {
        return view('admin.spot.form', compact('spot'));
    }

    public function update(Request $request, SpotWisata $spot): RedirectResponse
    {
        $data = $request->validate([
            'nama_spot' => ['required', 'string', 'max:150'],
            'deskripsi_singkat' => ['required', 'string', 'max:300'],
            'deskripsi_lengkap' => ['required', 'string'],
            'warna_bg' => ['required', 'regex:/^#[0-9a-fA-F]{3,8}$/'],
            'fotos' => ['nullable', 'array'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $fotoLama = $spot->getFotoList()->all();

        if ($request->has('hapus_foto')) {
            $hapus = $request->input('hapus_foto');
            UploadHelper::deleteAllExcept($spot->foto, array_diff($fotoLama, $hapus));
            $fotoLama = array_values(array_diff($fotoLama, $hapus));
        }

        $fotoLama = array_merge($fotoLama, $this->storePhotos($request->file('fotos', [])));

        $data['foto'] = implode(',', array_unique($fotoLama));
        unset($data['fotos']);

        $spot->update($data);

        return redirect()->route('admin.spot-wisata.index')->with('success', 'Spot wisata berhasil diperbarui.');
    }

    public function addPhotos(Request $request, SpotWisata $spot): RedirectResponse
    {
        $request->validate([
            'fotos' => ['required', 'array', 'min:1'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $baru = $this->storePhotos($request->file('fotos'));
        $gabungan = array_merge($spot->getFotoList()->all(), $baru);

        $spot->update(['foto' => implode(',', array_unique($gabungan))]);

        return back()->with('success', count($baru) . ' foto berhasil ditambahkan.');
    }

    public function destroy(SpotWisata $spot): RedirectResponse
    {
        UploadHelper::deleteList($spot->foto);
        $spot->delete();

        return redirect()->route('admin.spot-wisata.index')->with('success', 'Spot wisata berhasil dihapus.');
    }

    private function storePhotos(array $files): array
    {
        $paths = [];

        foreach ($files as $i => $file) {
            $paths[] = UploadHelper::store($file, 'spot');
        }

        return $paths;
    }
}
