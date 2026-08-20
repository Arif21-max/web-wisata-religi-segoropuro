@extends('layouts.admin')

@section('title', 'Berita & Acara')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola berita, agenda kegiatan, dan pengumuman.</p>
        <a href="{{ route('admin.berita.create') }}" class="btn-primary !py-2.5 !text-sm">
            <i class="fa-solid fa-plus"></i> Tambah Berita
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-stone-200 bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                        <th class="px-5 py-3.5">Judul</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Tanggal Kegiatan</th>
                        <th class="px-5 py-3.5">Penulis</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($berita as $item)
                        <tr class="transition hover:bg-stone-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ media_url($item->gambar) }}" alt="" class="h-10 w-14 shrink-0 rounded-lg object-cover">
                                    <div>
                                        <p class="font-semibold text-stone-800 line-clamp-1">{{ $item->judul }}</p>
                                        <p class="text-xs text-stone-400">{{ $item->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="rounded-full bg-gold-400/15 px-3 py-1 text-xs font-semibold text-gold-600">{{ $item->kategori }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-stone-600">{{ $item->tanggal_kegiatan?->format('d M Y') }}</td>
                            <td class="px-5 py-3.5 text-stone-600">{{ $item->penulis }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.berita.edit', $item) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition hover:bg-brand-100">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.berita.destroy', $item)"
                                        title="Hapus Berita"
                                        :name="$item->judul"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-stone-400">
                                <i class="fa-solid fa-newspaper mb-3 text-4xl"></i>
                                <p>Belum ada berita. Klik "Tambah Berita" untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$berita"/>
@endsection