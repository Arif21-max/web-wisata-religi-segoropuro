@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Barang' : 'Tambah Barang')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.barang-hilang.index') }}" class="text-sm font-semibold text-stone-500 hover:text-brand-700">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>

        <form action="{{ $item->exists ? route('admin.barang-hilang.update', $item) : route('admin.barang-hilang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 font-bold text-stone-900">Informasi Barang</h2>

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
                        <label for="nama_barang" class="mb-1.5 block text-sm font-semibold text-stone-700">Nama Barang *</label>
                        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $item->nama_barang) }}" required maxlength="200" placeholder="cth: Dompet Cokelat & Kartu Identitas" class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="mb-1.5 block text-sm font-semibold text-stone-700">Deskripsi *</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Ciri-ciri dan keterangan barang..." class="input-field resize-y">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                    </div>
                    <div>
                        <label for="lokasi_ditemukan" class="mb-1.5 block text-sm font-semibold text-stone-700">Lokasi Ditemukan *</label>
                        <input type="text" id="lokasi_ditemukan" name="lokasi_ditemukan" value="{{ old('lokasi_ditemukan', $item->lokasi_ditemukan) }}" required maxlength="200" placeholder="cth: Area Parkir Bus Ziarah" class="input-field">
                    </div>
                    <div>
                        <label for="tanggal_ditemukan" class="mb-1.5 block text-sm font-semibold text-stone-700">Tanggal Ditemukan *</label>
                        <input type="date" id="tanggal_ditemukan" name="tanggal_ditemukan" value="{{ old('tanggal_ditemukan', $item->tanggal_ditemukan?->format('Y-m-d')) }}" required class="input-field">
                    </div>
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-semibold text-stone-700">Status *</label>
                        <select id="status" name="status" required class="input-field">
                            @foreach (\App\Models\BarangHilang::STATUSES as $status)
                                <option value="{{ $status }}" @selected(old('status', $item->status ?? \App\Models\BarangHilang::STATUS_BELUM) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="konten_kontak" class="mb-1.5 block text-sm font-semibold text-stone-700">Kontak Info *</label>
                        <input type="text" id="konten_kontak" name="konten_kontak" value="{{ old('konten_kontak', $item->konten_kontak ?? 'Pengelola Makam / Satpam') }}" required maxlength="200" class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label for="foto" class="mb-1.5 block text-sm font-semibold text-stone-700">Foto Barang (opsional)</label>
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp,image/gif" class="input-field">
                        <p class="mt-1 text-xs text-stone-400">JPG, PNG, WEBP, GIF. Maksimal 5 MB. Bila kosong menggunakan gambar default.</p>
                        @if ($item->foto && ! str_contains($item->foto, 'dompet.jpg'))
                            <div class="mt-3 flex items-center gap-3">
                                <img src="{{ media_url($item->foto) }}" alt="" class="h-16 w-24 rounded-lg object-cover">
                                <span class="text-xs text-stone-500">Foto saat ini.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.barang-hilang.index') }}" class="btn-outline !py-2.5 !text-sm">Batal</a>
                <button type="submit" class="btn-primary !py-2.5 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Barang' }}
                </button>
            </div>
        </form>
    </div>
@endsection