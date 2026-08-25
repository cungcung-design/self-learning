<div class="gallery" id="gallery">
    <div class="container">
        <div class="section-heading">
            <h2>Gallery</h2>
            <p>A look at the rooms, lounge, and spaces around the hotel.</p>
        </div>
        <div class="row gallery-grid">
            @forelse ($gallery as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <img src="{{ $item->imageUrl() }}" alt="{{ config('hotel.name') }} gallery" />
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <h3>Photos coming soon</h3>
                        <p>We are updating the gallery. In the meantime, browse our rooms.</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if ($gallery->isNotEmpty())
            <div class="mt-2 mb-5 text-center">
                <a href="{{ route('gallery') }}" class="btn btn-hotel-outline">Open gallery</a>
            </div>
        @endif
    </div>
</div>
