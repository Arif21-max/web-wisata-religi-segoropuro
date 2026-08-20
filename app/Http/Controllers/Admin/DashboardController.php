<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\BarangHilang;
use App\Models\Berita;
use App\Models\BukuTamu;
use App\Models\SpotWisata;
use App\Models\StatistikPengunjung;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPengunjung = (int) StatistikPengunjung::sum('hits');
        $pengunjungHariIni = (int) StatistikPengunjung::where('tanggal', today())->sum('hits');
        $totalArtikel = Artikel::count();
        $totalBerita = Berita::count();
        $totalSpot = SpotWisata::count();
        $barangBelum = BarangHilang::where('status', BarangHilang::STATUS_BELUM)->count();
        $totalUlasan = BukuTamu::count();

        $aktivitas = Artikel::select('id', 'slug', 'judul', 'created_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $pengunjung30Hari = $this->pengunjungPerHari(29);
        $ulasan14Hari = $this->ulasanPerHari(13);
        $barangStatus = [
            'labels' => BarangHilang::STATUSES,
            'values' => array_map(
                fn (string $status) => (int) BarangHilang::where('status', $status)->count(),
                BarangHilang::STATUSES
            ),
        ];

        return view('admin.dashboard', compact(
            'totalPengunjung',
            'pengunjungHariIni',
            'totalArtikel',
            'totalBerita',
            'totalSpot',
            'barangBelum',
            'totalUlasan',
            'aktivitas',
            'pengunjung30Hari',
            'ulasan14Hari',
            'barangStatus',
        ));
    }

    private function pengunjungPerHari(int $hariTerakhir): array
    {
        $mulai = now()->subDays($hariTerakhir)->toDateString();

        $hitsPerTanggal = StatistikPengunjung::where('tanggal', '>=', $mulai)
            ->get(['tanggal', 'hits'])
            ->groupBy(fn ($row) => $row->tanggal->format('Y-m-d'))
            ->map(fn ($grup) => (int) $grup->sum('hits'));

        $labels = [];
        $values = [];

        foreach (range($hariTerakhir, 0) as $i) {
            $hari = now()->subDays($i);
            $labels[] = $hari->format('d M');
            $values[] = $hitsPerTanggal[$hari->format('Y-m-d')] ?? 0;
        }

        return compact('labels', 'values');
    }

    private function ulasanPerHari(int $hariTerakhir): array
    {
        $mulai = now()->subDays($hariTerakhir)->startOfDay();

        $ulasanPerHari = BukuTamu::where('created_at', '>=', $mulai)
            ->get(['created_at'])
            ->groupBy(fn ($row) => $row->created_at->format('Y-m-d'))
            ->map->count();

        $labels = [];
        $values = [];

        foreach (range($hariTerakhir, 0) as $i) {
            $hari = now()->subDays($i);
            $labels[] = $hari->format('d M');
            $values[] = $ulasanPerHari[$hari->format('Y-m-d')] ?? 0;
        }

        return compact('labels', 'values');
    }
}
