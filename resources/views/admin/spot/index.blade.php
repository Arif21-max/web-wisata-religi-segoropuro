@extends('layouts.admin')

@section('title', 'Spot Wisata & Galeri')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola spot wisata, fasilitas, dan galeri foto.</p>
        <a href="{{ route('admin.spot-wisata.create') }}" class="btn-primary !py-2.5 !text-sm">
            <i class="fa-solid fa-plus"></i> Tambah Spot
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-stone-200 bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                        <th class="px-5 py-3.5">Spot</th>
                        <th class="px-5 py-3.5">Galeri</th>
                        <th class="px-5 py-3.5">Deskripsi</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($spots as $item)
                        @php $fotoList = $item->getFotoList(); @endphp
                        <tr class="transition hover:bg-stone-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-9 w-9 shrink-0 rounded-lg" style="background: {{ $item->warna_bg }}"></span>
                                    <p class="font-semibold text-stone-800">{{ $item->nama_spot }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-2">
                                        @foreach ($fotoList->take(3) as $foto)
                                            <img src="{{ media_url($foto) }}" alt="" class="h-10 w-10 rounded-full border-2 border-white object-cover">
                                        @endforeach
                                    </div>
                                    <span class="text-xs text-stone-500">
                                        {{ $fotoList->count() }} foto
                                        @if ($fotoList->count() > 3)
                                            <span class="text-brand-700">+{{ $fotoList->count() - 3 }}</span>
                                        @endif
                                    </span>

                                    <form action="{{ route('admin.spot.foto-tambah', $item) }}" method="POST" enctype="multipart/form-data" class="ml-2" x-data>
                                        @csrf
                                        <button type="button" @click="$refs.foto.click()" title="Unggah foto tambahan" class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 transition hover:bg-sky-100">
                                            <i class="fa-solid fa-image"></i>
                                        </button>
                                        <input type="file" name="fotos[]" x-ref="foto" class="hidden" multiple accept="image/*" @change="$event.target.form.submit()">
                                    </form>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="max-w-xs text-stone-600 line-clamp-2">{{ $item->deskripsi_singkat }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.spot-wisata.edit', $item) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition hover:bg-brand-100">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.spot-wisata.destroy', $item)"
                                        title="Hapus Spot"
                                        :name="$item->nama_spot"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-stone-400">
                                <i class="fa-solid fa-mosque mb-3 text-4xl"></i>
                                <p>Belum ada spot wisata. Klik "Tambah Spot" untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$spots"/>
@endsection