      <section class="banner_main">
         <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="first-slide" src="{{ asset('images/banner1.jpg') }}" alt="Hotel banner">
               </div>
               <div class="carousel-item">
                  <img class="second-slide" src="{{ asset('images/banner2.jpg') }}" alt="Hotel banner">
               </div>
               <div class="carousel-item">
                  <img class="third-slide" src="{{ asset('images/banner3.jpg') }}" alt="Hotel banner">
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
         <div class="booking_ocline">
            <div class="container">
               <div class="row">
                  <div class="col-md-5">
                     <div class="book_room">
                        <h1>Book a Room Online</h1>
                        <form class="book_now" action="{{ route('home.public') }}" method="get">
                           <div class="row">
                              <div class="col-md-12">
                                 <span>Arrival</span>
                                 <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
                                 <input class="online_book" type="date" name="start_date" min="{{ date('Y-m-d') }}"
                                    value="{{ $filters['start_date'] ?? '' }}">
                              </div>
                              <div class="col-md-12">
                                 <span>Departure</span>
                                 <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
                                 <input class="online_book" type="date" name="end_date" min="{{ date('Y-m-d') }}"
                                    value="{{ $filters['end_date'] ?? '' }}">
                              </div>
                              <div class="col-md-12">
                                 <span>Room type</span>
                                 <select class="online_book" name="room_type" style="height: 50px;">
                                    <option value="">Any type</option>
                                    @foreach (\App\Models\Room::TYPES as $type)
                                        <option value="{{ $type }}" @selected(($filters['room_type'] ?? '') === $type)>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-12">
                                 <button class="book_btn" type="submit">Check Availability</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
