<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Support\UploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(): View
    {
        $berita = Berita::orderByDesc('id')->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create(): View
    {
        return view('admin.berita.form', ['berita' => new Berita]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $data['slug'] = unique_slug($data['judul'], 'berita');
        $data['gambar'] = $request->hasFile('gambar')
            ? UploadHelper::store($request->file('gambar'), 'berita')
            : 'uploads/hero.jpg';

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita): View
    {
        return view('admin.berita.form', compact('berita'));
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->filled('slug') && $request->input('slug') !== $berita->slug) {
            $data['slug'] = unique_slug($request->input('slug'), 'berita', $berita->id);
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('gambar')) {
            UploadHelper::delete($berita->gambar);
            $data['gambar'] = UploadHelper::store($request->file('gambar'), 'berita');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        UploadHelper::delete($berita->gambar);
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal_kegiatan' => ['required', 'date'],
            'penulis' => ['required', 'string', 'max:100'],
            'ringkasan' => ['required', 'string', 'max:1000'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);
    }
}
