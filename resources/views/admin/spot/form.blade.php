@extends('layouts.admin')

@section('title', $spot->exists ? 'Edit Spot Wisata' : 'Tambah Spot Wisata')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.spot-wisata.index') }}" class="text-sm font-semibold text-stone-500 hover:text-brand-700">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>

        <form action="{{ $spot->exists ? route('admin.spot-wisata.update', $spot) : route('admin.spot-wisata.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($spot->exists)
                @method('PUT')
            @endif

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 font-bold text-stone-900">Informasi Spot</h2>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="nama_spot" class="mb-1.5 block text-sm font-semibold text-stone-700">Nama Spot *</label>
                        <input type="text" id="nama_spot" name="nama_spot" value="{{ old('nama_spot', $spot->nama_spot) }}" required maxlength="150" placeholder="cth: Area Makam Utama" class="input-field">
                    </div>
                    <div>
                        <label for="deskripsi_singkat" class="mb-1.5 block text-sm font-semibold text-stone-700">Deskripsi Singkat *</label>
                        <input type="text" id="deskripsi_singkat" name="deskripsi_singkat" value="{{ old('deskripsi_singkat', $spot->deskripsi_singkat) }}" required maxlength="300" placeholder="Tampil di kartu spot" class="input-field">
                    </div>
                    <div>
                        <label for="warna_bg" class="mb-1.5 block text-sm font-semibold text-stone-700">Warna Aksen *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="warna_bg" name="warna_bg" value="{{ old('warna_bg', $spot->warna_bg ?? '#2c3e50') }}" required class="h-11 w-14 cursor-pointer rounded-lg border border-stone-300 p-1">
                            <input type="text" value="{{ old('warna_bg', $spot->warna_bg ?? '#2c3e50') }}" readonly class="input-field w-28 bg-stone-50 text-xs">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="deskripsi_lengkap" class="mb-1.5 block text-sm font-semibold text-stone-700">Deskripsi Lengkap *</label>
                        <textarea id="deskripsi_lengkap" name="deskripsi_lengkap" rows="6" required placeholder="Deskripsi detail yang tampil di popup..." class="input-field resize-y">{{ old('deskripsi_lengkap', $spot->deskripsi_lengkap) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="fotos" class="mb-1.5 block text-sm font-semibold text-stone-700">Foto Spot (bisa banyak)</label>
                        <input type="file" id="fotos" name="fotos[]" multiple accept="image/jpeg,image/png,image/webp,image/gif" class="input-field">
                        <p class="mt-1 text-xs text-stone-400">Pilih beberapa file sekaligus (CTRL/Shift + klik). JPG, PNG, WEBP, GIF. Maksimal 5 MB per file.</p>
                    </div>

                    @if ($spot->exists && $spot->getFotoList()->isNotEmpty())
                        <div class="md:col-span-2">
                            <p class="mb-2 text-sm font-semibold text-stone-700">Galeri Saat Ini <span class="font-normal text-stone-400">(centang untuk menghapus)</span></p>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                                @foreach ($spot->getFotoList() as $foto)
                                    <label class="group relative cursor-pointer overflow-hidden rounded-xl border border-stone-200">
                                        <img src="{{ media_url($foto) }}" alt="" loading="lazy" class="h-28 w-full object-cover">
                                        <input type="checkbox" name="hapus_foto[]" value="{{ $foto }}" class="peer absolute right-2 top-2 h-4 w-4 accent-red-600">
                                        <span class="pointer-events-none absolute inset-0 flex items-center justify-center bg-red-600/70 text-white opacity-0 transition group-hover:opacity-100 peer-checked:opacity-100">
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.spot-wisata.index') }}" class="btn-outline !py-2.5 !text-sm">Batal</a>
                <button type="submit" class="btn-primary !py-2.5 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $spot->exists ? 'Simpan Perubahan' : 'Simpan Spot' }}
                </button>
            </div>
        </form>
    </div>
@endsection