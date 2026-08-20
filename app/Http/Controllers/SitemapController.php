<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\SpotWisata;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $lastmod = fn ($value) => Carbon::parse($value)->toDateString();

        $urls = collect([
            ['loc' => url('/'), 'lastmod' => now()->toDateString(), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('sejarah.index'), 'lastmod' => $lastmod(Artikel::query()->max('updated_at')), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('spot-wisata.index'), 'lastmod' => $lastmod(SpotWisata::query()->max('updated_at')), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('berita.index'), 'lastmod' => $lastmod(Berita::query()->max('updated_at')), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('buku-tamu.index'), 'changefreq' => 'monthly', 'priority' => '0.4'],
            ['loc' => route('barang-hilang.index'), 'changefreq' => 'monthly', 'priority' => '0.4'],
        ]);

        $urls = $urls->concat(
            Berita::query()->orderByDesc('updated_at')->get()
                ->map(fn (Berita $item) => [
                    'loc' => route('berita.show', $item),
                    'lastmod' => $item->updated_at?->toDateString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ])
        )->concat(
            Artikel::query()->orderByDesc('updated_at')->get()
                ->map(fn (Artikel $item) => [
                    'loc' => route('sejarah.show', $item),
                    'lastmod' => $item->updated_at?->toDateString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ])
        )->concat(
            SpotWisata::query()->orderByDesc('updated_at')->get()
                ->map(fn (SpotWisata $item) => [
                    'loc' => route('spot-wisata.show', $item),
                    'lastmod' => $item->updated_at?->toDateString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ])
        );

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.e((string) $url['loc'])."</loc>\n";
            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>'.$url['lastmod']."</lastmod>\n";
            }
            $xml .= '    <changefreq>'.$url['changefreq']."</changefreq>\n";
            $xml .= '    <priority>'.$url['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
