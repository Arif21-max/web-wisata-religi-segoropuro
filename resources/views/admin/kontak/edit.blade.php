@extends('layouts.admin')

@section('title', 'Kontak')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <p class="text-sm text-stone-500">Kelola informasi kontak yang tampil di situs (footer, tombol WhatsApp, dan peta lokasi).</p>
        </div>

        <form action="{{ route('admin.kontak.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 font-bold text-stone-900">Informasi Kontak</h2>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="alamat" class="mb-1.5 block text-sm font-semibold text-stone-700">Alamat *</label>
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $kontak->alamat ?? '') }}" required maxlength="255" class="input-field">
                    </div>
                    <div>
                        <label for="whatsapp_number" class="mb-1.5 block text-sm font-semibold text-stone-700">Nomor WhatsApp *</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $kontak->whatsapp_number ?? '') }}" required maxlength="30" placeholder="cth: 628123456789" class="input-field">
                        <p class="mt-1 text-xs text-stone-400">Format internasional tanpa tanda +, diawali 62.</p>
                    </div>
                    <div>
                        <label for="whatsapp_default_message" class="mb-1.5 block text-sm font-semibold text-stone-700">Pesan Default WhatsApp</label>
                        <input type="text" id="whatsapp_default_message" name="whatsapp_default_message" value="{{ old('whatsapp_default_message', $kontak->whatsapp_default_message ?? '') }}" maxlength="500" class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label for="google_maps_embed" class="mb-1.5 block text-sm font-semibold text-stone-700">Embed Google Maps</label>
                        <textarea id="google_maps_embed" name="google_maps_embed" rows="4" placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...&gt;&lt;/iframe&gt;" class="input-field">{{ old('google_maps_embed', $kontak->google_maps_embed ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-stone-400">Tempel kode embed iframe dari Google Maps. Kosongkan untuk menyembunyikan peta.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-xl border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                    Batal
                </a>
                <button type="submit" class="btn-primary !py-2.5 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
