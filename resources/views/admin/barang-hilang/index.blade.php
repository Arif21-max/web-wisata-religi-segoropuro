@extends('layouts.admin')

@section('title', 'Barang Hilang')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola laporan barang temuan dan status klaim.</p>
        <a href="{{ route('admin.barang-hilang.create') }}" class="btn-primary !py-2.5 !text-sm">
            <i class="fa-solid fa-plus"></i> Tambah Barang
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-stone-200 bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                        <th class="px-5 py-3.5">Barang</th>
                        <th class="px-5 py-3.5">Lokasi</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($items as $item)
                        <tr class="transition hover:bg-stone-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if ($item->foto && ! str_contains($item->foto, 'dompet.jpg') && ! str_contains($item->foto, 'default-item.jpg') && ! str_contains($item->foto, 'kacamata.jpg') && ! str_contains($item->foto, 'payung.jpg'))
                                        <img src="{{ media_url($item->foto) }}" alt="" class="h-10 w-14 shrink-0 rounded-lg object-cover">
                                    @else
                                        <span class="flex h-10 w-14 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-400"><i class="fa-solid fa-box-open"></i></span>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-stone-800">{{ $item->nama_barang }}</p>
                                        <p class="max-w-xs text-xs text-stone-400 line-clamp-1">{{ $item->deskripsi }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-stone-600">{{ $item->lokasi_ditemukan }}</td>
                            <td class="px-5 py-3.5 text-stone-500">{{ $item->tanggal_ditemukan?->format('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <form action="{{ route('admin.barang-hilang.toggle', $item) }}" method="POST" title="Klik untuk ubah status">
                                    @csrf
                                    <button type="submit" @class([
                                        'flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold transition',
                                        'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' => $item->isSudahDiambil(),
                                        'bg-rose-100 text-rose-700 hover:bg-rose-200' => ! $item->isSudahDiambil(),
                                    ])>
                                        <i class="fa-solid fa-retweet"></i> {{ $item->status }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.barang-hilang.edit', $item) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition hover:bg-brand-100">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.barang-hilang.destroy', $item)"
                                        title="Hapus Data Barang"
                                        :name="$item->nama_barang"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-stone-400">
                                <i class="fa-solid fa-box-open mb-3 text-4xl"></i>
                                <p>Belum ada data barang. Klik "Tambah Barang" untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$items"/>
@endsection