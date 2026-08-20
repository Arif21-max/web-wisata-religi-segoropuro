@extends('layouts.admin')

@section('title', 'Buku Tamu')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Daftar pesan & doa dari peziarah. Ulasan hanya bisa dihapus.</p>
        <form action="{{ route('admin.buku-tamu.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari ulasan..." class="input-field !w-56">
            <button type="submit" class="shrink-0 rounded-xl bg-brand-700 px-4 py-2.5 text-white transition hover:bg-brand-800">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-stone-200 bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                        <th class="px-5 py-3.5">Pengunjung</th>
                        <th class="px-5 py-3.5">Pesan / Doa</th>
                        <th class="px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($ulasan as $item)
                        <tr class="transition hover:bg-stone-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">{{ $item->getInisial() }}</span>
                                    <div>
                                        <p class="font-semibold text-stone-800">{{ $item->nama }}</p>
                                        <p class="text-xs text-stone-400"><i class="fa-solid fa-location-dot me-1"></i>{{ $item->asal_kota }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="max-w-md line-clamp-2 text-stone-600">"{{ $item->pesan_doa }}"</p>
                            </td>
                            <td class="px-5 py-3.5 text-stone-500">{{ $item->created_at?->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end">
                                    <x-admin.delete-modal
                                        :action="route('admin.buku-tamu.destroy', $item)"
                                        title="Hapus Ulasan"
                                        :name="$item->nama"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-stone-400">
                                <i class="fa-solid fa-book mb-3 text-4xl"></i>
                                <p>Belum ada ulasan{{ $q !== '' ? ' yang cocok' : '' }}.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$ulasan"/>
@endsection