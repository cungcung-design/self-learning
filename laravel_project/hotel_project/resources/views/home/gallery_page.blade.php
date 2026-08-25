<x-public-layout title="Gallery">
    @include('home.partials.page-hero', [
        'title' => 'Gallery',
        'subtitle' => 'Photos from the hotel, rooms, and shared spaces.',
    ])

    <section class="page-section">
        <div class="container">
            <div class="row gallery-grid">
                @forelse ($gallery as $item)
                    <div class="col-6 col-md-4 col-lg-3">
                        <img src="{{ $item->imageUrl() }}" alt="{{ config('hotel.name') }} gallery" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <h3>No gallery photos yet</h3>
                            <p>Please check back soon, or explore the rooms while we update this page.</p>
                            <a href="{{ route('rooms.index') }}" class="btn btn-hotel">Browse rooms</a>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $gallery->links() }}
            </div>
        </div>
    </section>
</x-public-layout>
