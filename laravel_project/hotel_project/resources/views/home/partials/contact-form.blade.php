<form id="request" class="main_form hotel-form" action="{{ route('contact.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <input class="contactus @error('name') is-invalid @enderror" placeholder="Name" required type="text"
                name="name" value="{{ old('name') }}" autocomplete="name">
            @error('name')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <input class="contactus @error('email') is-invalid @enderror" placeholder="Email" type="email" name="email"
                required value="{{ old('email') }}" autocomplete="email">
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <input class="contactus @error('phone') is-invalid @enderror" placeholder="Phone Number" type="tel"
                name="phone" required value="{{ old('phone') }}" autocomplete="tel">
            @error('phone')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <textarea class="textarea @error('message') is-invalid @enderror" placeholder="Message" name="message" required>{{ old('message') }}</textarea>
            @error('message')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <button type="submit" class="send_btn">Send message</button>
        </div>
    </div>
</form>
