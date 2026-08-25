<x-public-layout>
    @include('home.slider')
    @include('home.about')
    @include('home.room')
    @include('home.gallery')
    @include('home.contact')

    @push('scripts')
        <script>
            $(document).ready(function() {
                @if (! empty($searching))
                    sessionStorage.removeItem('scrollTop');
                    if ($('#rooms').length) {
                        $('html, body').animate({
                            scrollTop: $('#rooms').offset().top - 20
                        }, 400);
                    }
                @elseif ($errors->hasAny(['name', 'email', 'phone', 'message']))
                    if ($('#contact').length) {
                        $('html, body').animate({
                            scrollTop: $('#contact').offset().top - 20
                        }, 400);
                    }
                @endif
            });
        </script>
    @endpush
</x-public-layout>
