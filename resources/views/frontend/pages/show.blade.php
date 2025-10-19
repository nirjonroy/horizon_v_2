@extends('frontend.app')

@section('title', $page->title . ' | Horizons Unlimited')

@section('seos')
    @php
        $description = \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160);
    @endphp
    <meta name="description" content="{{ $description }}">
@endsection

@section('content')
<section class="pt-32 pb-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-primary">{{ $page->title }}</h1>
                    @if ($page->updated_at)
                        <p class="text-sm text-gray-500 mt-2">
                            Last updated {{ $page->updated_at->format('F d, Y') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-8 page-content text-gray-700 leading-relaxed space-y-6">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    .page-content h1,
    .page-content h2,
    .page-content h3 {
        color: #001D42;
        font-weight: 600;
        margin-top: 1.5rem;
    }

    .page-content p {
        margin-bottom: 1rem;
    }

    .page-content ul,
    .page-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .page-content a {
        color: #001D42;
        text-decoration: underline;
    }
</style>
