<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SejarahController extends Controller
{
    public function redirectToSlug(int $id): RedirectResponse
    {
        $artikel = Artikel::find($id);

        abort_unless($artikel, 404);

        return redirect()->route('sejarah.show', $artikel, 301);
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $artikel = Artikel::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%")
                        ->orWhere('kutipan', 'like', "%{$q}%")
                        ->orWhere('kategori', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(6)
            ->withQueryString();

        $artikel->each(function (Artikel $item) {
            $item->konten_html = collect(preg_split('/\r?\n+/', (string) $item->konten))
                ->map(fn (string $baris) => trim($baris))
                ->filter()
                ->map(fn (string $baris) => '<p>'.e($baris).'</p>')
                ->implode('');
        });

        $kategoriList = Artikel::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('pages.sejarah', compact('artikel', 'q', 'kategoriList'));
    }

    public function show(Artikel $artikel): View
    {
        $artikel->konten_html = collect(preg_split('/\r?\n+/', (string) $artikel->konten))
            ->map(fn (string $baris) => trim($baris))
            ->filter()
            ->map(fn (string $baris) => '<p>'.e($baris).'</p>')
            ->implode('');

        $artikelLain = Artikel::query()
            ->where('id', '!=', $artikel->id)
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('pages.sejarah-detail', compact('artikel', 'artikelLain'));
    }
}
