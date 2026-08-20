@extends('layouts.admin')

@section('title', 'Literasi Sejarah')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola artikel literasi sejarah kawasan wisata religi.</p>
        <a href="{{ route('admin.artikel.create') }}" class="btn-primary !py-2.5 !text-sm">
            <i class="fa-solid fa-plus"></i> Tambah Artikel
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-stone-200 bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                        <th class="px-5 py-3.5">Judul</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Penulis</th>
                        <th class="px-5 py-3.5">Dibuat</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($artikel as $item)
                        <tr class="transition hover:bg-stone-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if ($item->gambar)
                                        <img src="{{ media_url($item->gambar) }}" alt="" class="h-10 w-14 shrink-0 rounded-lg object-cover">
                                    @endif
                                    <div>
                                        <p class="font-semibold text-stone-800 line-clamp-1">{{ $item->judul }}</p>
                                        <p class="text-xs text-stone-400">{{ $item->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">{{ $item->kategori }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-stone-600">{{ $item->penulis }}</td>
                            <td class="px-5 py-3.5 text-stone-500">{{ $item->created_at?->format('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.artikel.edit', $item) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition hover:bg-brand-100">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.artikel.destroy', $item)"
                                        title="Hapus Artikel"
                                        :name="$item->judul"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-stone-400">
                                <i class="fa-solid fa-book-open mb-3 text-4xl"></i>
                                <p>Belum ada artikel. Klik "Tambah Artikel" untuk mulai menulis.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$artikel"/>
@endsection