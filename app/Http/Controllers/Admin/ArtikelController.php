<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Support\UploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtikelController extends Controller
{
    public function index(): View
    {
        $artikel = Artikel::orderByDesc('id')->paginate(10);

        return view('admin.artikel.index', compact('artikel'));
    }

    public function create(): View
    {
        return view('admin.artikel.form', ['artikel' => new Artikel]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $data['slug'] = unique_slug($data['judul'], 'artikel');
        $data['gambar'] = $request->hasFile('gambar')
            ? UploadHelper::store($request->file('gambar'), 'art')
            : null;

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Artikel $artikel): View
    {
        return view('admin.artikel.form', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->filled('slug') && $request->input('slug') !== $artikel->slug) {
            $data['slug'] = unique_slug($request->input('slug'), 'artikel', $artikel->id);
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('gambar')) {
            UploadHelper::delete($artikel->gambar);
            $data['gambar'] = UploadHelper::store($request->file('gambar'), 'art');
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel): RedirectResponse
    {
        UploadHelper::delete($artikel->gambar);
        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'penulis' => ['required', 'string', 'max:100'],
            'konten' => ['required', 'string'],
            'kutipan' => ['nullable', 'string', 'max:500'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);
    }
}
