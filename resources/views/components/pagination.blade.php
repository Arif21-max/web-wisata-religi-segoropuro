@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="mt-10 flex flex-col items-center gap-3" aria-label="Paginasi">
        <div class="flex items-center gap-1.5 overflow-x-auto rounded-full border border-stone-200 bg-white p-1.5 shadow-sm">
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="flex h-9 w-9 items-center justify-center rounded-full text-stone-300" aria-disabled="true">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex h-9 w-9 items-center justify-center rounded-full text-stone-600 transition hover:bg-brand-50 hover:text-brand-800">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="flex h-9 min-w-9 items-center justify-center rounded-full bg-brand-700 px-2 text-sm font-bold text-white" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="flex h-9 min-w-9 items-center justify-center rounded-full px-2 text-sm font-medium text-stone-600 transition hover:bg-brand-50 hover:text-brand-800">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex h-9 w-9 items-center justify-center rounded-full text-stone-600 transition hover:bg-brand-50 hover:text-brand-800">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="flex h-9 w-9 items-center justify-center rounded-full text-stone-300" aria-disabled="true">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
            @endif
        </div>

        <p class="text-xs text-stone-400">
            Menampilkan <strong>{{ $paginator->firstItem() ?: 0 }}</strong>–<strong>{{ $paginator->lastItem() ?: 0 }}</strong> dari <strong>{{ $paginator->total() }}</strong> data
        </p>
    </nav>
@endif