      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ ($title ?? null) ? $title.' — '.config('hotel.name') : config('hotel.name') }}</title>
      <meta name="keywords" content="hotel, rooms, booking, {{ config('hotel.name') }}">
      <meta name="description" content="{{ config('hotel.tagline') }}">
      <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
      <link rel="icon" href="{{ asset('images/fevicon.png') }}" type="image/gif" />
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
