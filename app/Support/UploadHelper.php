<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    private const EKSTENSI_DIIZINKAN = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public static function store(UploadedFile $file, string $prefix = 'file'): string
    {
        $ekstensi = strtolower((string) $file->guessExtension());

        if (! in_array($ekstensi, self::EKSTENSI_DIIZINKAN, true)) {
            $ekstensi = 'bin';
        }

        $nama = $prefix . '_' . time() . '_' . random_int(1000, 9999) . '.' . $ekstensi;

        $file->storeAs('uploads', $nama, 'public');

        return 'uploads/' . $nama;
    }

    public static function delete(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    /**
     * Hapus daftar file (string dipisah koma) yang tidak dipakai lagi.
     */
    public static function deleteList(?string $paths): void
    {
        if (! $paths) {
            return;
        }

        foreach (array_filter(array_map('trim', explode(',', $paths))) as $path) {
            static::delete($path);
        }
    }

    public static function deleteAllExcept(?string $paths, array $keep): void
    {
        if (! $paths) {
            return;
        }

        foreach (array_filter(array_map('trim', explode(',', $paths))) as $path) {
            if (! in_array($path, $keep, true)) {
                static::delete($path);
            }
        }
    }
}
