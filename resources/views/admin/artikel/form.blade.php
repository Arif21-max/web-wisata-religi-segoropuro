@extends('layouts.admin')

@section('title', $artikel->exists ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.artikel.index') }}" class="text-sm font-semibold text-stone-500 hover:text-brand-700">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>

        <form action="{{ $artikel->exists ? route('admin.artikel.update', $artikel) : route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($artikel->exists)
                @method('PUT')
            @endif

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 font-bold text-stone-900">Informasi Artikel</h2>

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
                        <label for="judul" class="mb-1.5 block text-sm font-semibold text-stone-700">Judul Artikel *</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}" required maxlength="255" placeholder="cth: Sejarah Sayyid Arif Segoropuro" class="input-field">
                    </div>
                    <div>
                        <label for="kategori" class="mb-1.5 block text-sm font-semibold text-stone-700">Kategori *</label>
                        <input type="text" id="kategori" name="kategori" list="kategori-list" value="{{ old('kategori', $artikel->kategori ?? 'Sejarah Islam') }}" required maxlength="100" class="input-field">
                        <datalist id="kategori-list">
                            <option value="Sejarah Islam">
                            <option value="Kearifan Lokal">
                            <option value="Biografi">
                            <option value="Kegiatan">
                        </datalist>
                    </div>
                    <div>
                        <label for="penulis" class="mb-1.5 block text-sm font-semibold text-stone-700">Penulis *</label>
                        <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $artikel->penulis ?? 'Admin Desa') }}" required maxlength="100" class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label for="kutipan" class="mb-1.5 block text-sm font-semibold text-stone-700">Kutipan</label>
                        <input type="text" id="kutipan" name="kutipan" value="{{ old('kutipan', $artikel->kutipan) }}" maxlength="500" placeholder="Kalimat kutipan pengantar artikel (opsional)" class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label for="konten" class="mb-1.5 block text-sm font-semibold text-stone-700">Isi Konten *</label>
                        <textarea id="konten" name="konten" rows="10" required placeholder="Tulis isi artikel di sini..." class="input-field resize-y">{{ old('konten', $artikel->konten) }}</textarea>
                        <p class="mt-1 text-xs text-stone-400">Gunakan baris kosong untuk memisahkan paragraf.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="gambar" class="mb-1.5 block text-sm font-semibold text-stone-700">Gambar Artikel</label>
                        <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp,image/gif" class="input-field">
                        <p class="mt-1 text-xs text-stone-400">JPG, PNG, WEBP, GIF. Maksimal 5 MB.</p>

                        @if ($artikel->gambar)
                            <div class="mt-3 flex items-center gap-3">
                                <img src="{{ media_url($artikel->gambar) }}" alt="" class="h-16 w-24 rounded-lg object-cover">
                                <span class="text-xs text-stone-500">Gambar saat ini. Unggah file baru untuk menggantinya.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.artikel.index') }}" class="btn-outline !py-2.5 !text-sm">Batal</a>
                <button type="submit" class="btn-primary !py-2.5 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $artikel->exists ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                </button>
            </div>
        </form>
    </div>
@endsection