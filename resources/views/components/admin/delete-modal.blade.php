@props([
    'action' => '',
    'title' => 'Hapus Data',
    'name' => '',
    'message' => null,
    'confirmText' => 'Ya, Hapus',
])

<div
    x-data="{ open: false }"
    class="inline-flex"
    @keydown.escape.window="open = false"
>
    {{-- Tombol pemicu --}}
    <button
        type="button"
        title="Hapus"
        @click="open = true"
        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100"
    >
        <i class="fa-solid fa-trash"></i>
    </button>

    {{-- Modal konfirmasi --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity.duration.200ms
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        :aria-labelledby="$id('delete-modal-title')"
    >
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/60" @click="open = false"></div>

        {{-- Panel modal --}}
        <div
            x-show="open"
            x-transition.scale.90.duration.200ms
            class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start gap-4 p-6">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                </span>

                <div class="min-w-0 flex-1">
                    <h3 :id="$id('delete-modal-title')" class="font-display text-lg font-bold text-stone-900">{{ $title }}</h3>

                    @if ($name)
                        <p class="mt-1 text-sm leading-relaxed text-stone-500">Anda akan menghapus permanen:</p>
                        <p class="mt-0.5 line-clamp-2 text-sm font-semibold text-stone-800">"{{ $name }}"</p>
                    @elseif ($message)
                        <p class="mt-1 text-sm leading-relaxed text-stone-500">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-sm leading-relaxed text-stone-500">Yakin ingin menghapus data ini?</p>
                    @endif

                    <p class="mt-2 text-xs font-semibold text-red-500">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-stone-100 bg-stone-50 px-6 py-4">
                <button type="button" @click="open = false" class="btn-outline !px-4 !py-2 !text-sm">
                    Batal
                </button>

                <form action="{{ $action }}" method="POST" x-data="{ deleting: false }" @submit="deleting = true">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        :disabled="deleting"
                        class="btn-danger !px-4 !py-2 !text-sm disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <i class="fa-solid fa-trash" x-show="!deleting"></i>
                        <i class="fa-solid fa-spinner fa-spin" x-show="deleting" x-cloak></i>
                        <span class="ms-1" x-text="deleting ? 'Menghapus...' : @js($confirmText)"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
