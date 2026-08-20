@extends('layouts.admin')

@section('title', $berita->exists ? 'Edit Berita' : 'Tambah Berita')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.berita.index') }}" class="text-sm font-semibold text-stone-500 hover:text-brand-700">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>

        <form action="{{ $berita->exists ? route('admin.berita.update', $berita) : route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($berita->exists)
                @method('PUT')
            @endif

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 font-bold text-stone-900">Informasi Berita</h2>

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
                        <label for="judul" class="mb-1.5 block text-sm font-semibold text-stone-700">Judul Berita *</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required maxlength="255" placeholder="cth: Peringatan Haul Agung Tahun 2026" class="input-field">
                    </div>
                    <div>
                        <label for="kategori" class="mb-1.5 block text-sm font-semibold text-stone-700">Kategori *</label>
                        <input type="text" id="kategori" name="kategori" list="kategori-list" value="{{ old('kategori', $berita->kategori ?? 'Acara Religi') }}" required maxlength="100" class="input-field">
                        <datalist id="kategori-list">
                            <option value="Acara Religi">
                            <option value="Kegiatan Desa">
                            <option value="Pengumuman">
                        </datalist>
                    </div>
                    <div>
                        <label for="tanggal_kegiatan" class="mb-1.5 block text-sm font-semibold text-stone-700">Tanggal Kegiatan *</label>
                        <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $berita->tanggal_kegiatan?->format('Y-m-d')) }}" required class="input-field">
                    </div>
                    <div>
                        <label for="penulis" class="mb-1.5 block text-sm font-semibold text-stone-700">Penulis *</label>
                        <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis ?? 'Panitia Pengelola') }}" required maxlength="100" class="input-field">
                    </div>
                    <div>
                        <label for="gambar" class="mb-1.5 block text-sm font-semibold text-stone-700">Gambar Berita</label>
                        <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp,image/gif" class="input-field">
                        <p class="mt-1 text-xs text-stone-400">JPG, PNG, WEBP, GIF. Maksimal 5 MB.</p>
                        @if ($berita->gambar)
                            <div class="mt-3 flex items-center gap-3">
                                <img src="{{ media_url($berita->gambar) }}" alt="" class="h-16 w-24 rounded-lg object-cover">
                                <span class="text-xs text-stone-500">Gambar saat ini (default bila kosong).</span>
                            </div>
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <label for="ringkasan" class="mb-1.5 block text-sm font-semibold text-stone-700">Ringkasan *</label>
                        <textarea id="ringkasan" name="ringkasan" rows="3" required maxlength="1000" placeholder="Ringkasan singkat berita yang tampil di kartu..." class="input-field resize-y">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="konten" class="mb-1.5 block text-sm font-semibold text-stone-700">Isi Konten *</label>
                        <textarea id="konten" name="konten" rows="10" required placeholder="Tulis isi berita di sini..." class="input-field resize-y">{{ old('konten', $berita->konten) }}</textarea>
                        <p class="mt-1 text-xs text-stone-400">Gunakan baris kosong untuk memisahkan paragraf.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.berita.index') }}" class="btn-outline !py-2.5 !text-sm">Batal</a>
                <button type="submit" class="btn-primary !py-2.5 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $berita->exists ? 'Simpan Perubahan' : 'Simpan Berita' }}
                </button>
            </div>
        </form>
    </div>
@endsection