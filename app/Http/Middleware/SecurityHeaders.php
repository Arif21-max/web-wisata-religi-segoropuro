<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        $response->headers->set('X-XSS-Protection', '0');

        if (! $response->headers->has('Content-Security-Policy')) {
            $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy());
        }

        return $response;
    }

    private function contentSecurityPolicy(): string
    {
        // 'unsafe-eval' wajib ada karena Alpine.js mengevaluasi binding
        // (x-data, x-show, @click) via new Function(). Tanpa ini seluruh
        // interaksi Alpine (menu mobile, sidebar, dll) tidak berfungsi.
        $scriptSrc = "'self' 'unsafe-eval'";
        $connectSrc = "'self'";
        $styleSrc = "'self' 'unsafe-inline' https://fonts.googleapis.com";
        $fontSrc = "'self' https://fonts.gstatic.com";

        // '[::1]' sengaja tidak dipakai: sintaks `http://[::1]:*` tidak valid
        // menurut spesifikasi CSP sehingga browser mengabaikannya dengan warning.
        $devOrigins = ['localhost', '127.0.0.1'];

        $hotFile = public_path('hot');
        if (file_exists($hotFile)) {
            $host = (string) parse_url((string) file_get_contents($hotFile), PHP_URL_HOST);
            if ($host !== '') {
                $devOrigins[] = $host;
            }
        }

        if (app()->isLocal() || file_exists($hotFile)) {
            $origins = implode(' ', array_map(fn (string $host) => "http://{$host}:* ws://{$host}:*", $devOrigins));
            $httpOrigins = implode(' ', array_map(fn (string $host) => "http://{$host}:*", $devOrigins));

            $scriptSrc .= " {$origins}";
            $connectSrc .= " {$origins}";
            $styleSrc .= " {$httpOrigins}";
            $fontSrc .= " {$httpOrigins}";
        }

        return implode('; ', [
            "default-src 'self'",
            "script-src {$scriptSrc}",
            "style-src {$styleSrc}",
            "font-src {$fontSrc}",
            "img-src 'self' data: https:",
            "frame-src https://www.google.com https://maps.google.com",
            "connect-src {$connectSrc}",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ]);
    }
}
