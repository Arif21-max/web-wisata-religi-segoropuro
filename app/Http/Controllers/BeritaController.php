<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function redirectToSlug(int $id): RedirectResponse
    {
        $berita = Berita::find($id);

        abort_unless($berita, 404);

        return redirect()->route('berita.show', $berita, 301);
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));
        $kategori = trim((string) $request->query('kategori'));

        $berita = Berita::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%")
                        ->orWhere('ringkasan', 'like', "%{$q}%");
                });
            })
            ->when($kategori !== '', fn ($query) => $query->where('kategori', $kategori))
            ->orderByDesc('tanggal_kegiatan')
            ->paginate(6)
            ->withQueryString();

        $berita->each(function (Berita $item) {
            $item->konten_html = collect(preg_split('/\r?\n+/', (string) $item->konten))
                ->map(fn (string $baris) => trim($baris))
                ->filter()
                ->map(fn (string $baris) => '<p>'.e($baris).'</p>')
                ->implode('');
        });

        $kategoriList = Berita::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('pages.berita', compact('berita', 'q', 'kategori', 'kategoriList'));
    }

    public function show(Berita $berita): View
    {
        $berita->konten_html = collect(preg_split('/\r?\n+/', (string) $berita->konten))
            ->map(fn (string $baris) => trim($baris))
            ->filter()
            ->map(fn (string $baris) => '<p>'.e($baris).'</p>')
            ->implode('');

        $beritaLain = Berita::query()
            ->where('id', '!=', $berita->id)
            ->orderByDesc('tanggal_kegiatan')
            ->limit(3)
            ->get();

        return view('pages.berita-detail', compact('berita', 'beritaLain'));
    }
}
