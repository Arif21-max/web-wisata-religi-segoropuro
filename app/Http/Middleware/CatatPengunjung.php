<?php

namespace App\Http\Middleware;

use App\Models\StatistikPengunjung;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CatatPengunjung
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/*', 'up', 'storage/*')) {
            return $next($request);
        }

        try {
            $ip = $request->ip() ?? '127.0.0.1';
            $tanggal = now()->toDateString();

            // Simpan IP sebagai hash HMAC (pseudo-anonim) agar tidak menyimpan
            // data pribadi pengunjung mentah, tetapi tetap bisa dihitung unik.
            $ipAnonim = hash_hmac('sha256', (string) $ip, (string) config('app.key'));

            $statistik = StatistikPengunjung::firstOrCreate(
                ['ip_address' => $ipAnonim, 'tanggal' => $tanggal],
                ['hits' => 0],
            );

            $statistik->increment('hits');
        } catch (\Throwable $e) {
            // abaikan error pencatatan agar halaman tetap berjalan
        }

        return $next($request);
    }
}
