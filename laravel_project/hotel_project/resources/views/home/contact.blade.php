     <div class="contact">
         <div class="container">
             <div class="row">
                 <div class="col-md-12">
                     <div class="titlepage">
                         <h2>Contact Us</h2>
                     </div>
               @if (session()->has('message'))
    <div id="flash-message" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px;">
        {{ session()->get('message') }}
    </div>

    <script>
        setTimeout(function() {
            var message = document.getElementById('flash-message');
            if (message) {
                message.style.display = 'none';
              
            }
        }, 5000);
    </script>
@endif
                 </div>

             </div>
             <div class="row">
                 <div class="col-md-6">
                     <form id="request" class="main_form" action = "{{ url('contact') }}  " method="POST">
                        @csrf
                         <div class="row">
                             <div class="col-md-12 ">
                                 <input class="contactus" placeholder="Name" required type="type" name="name">
                             </div>
                             <div class="col-md-12">
                                 <input class="contactus" placeholder="Email" type="type" name="email" required>
                             </div>
                             <div class="col-md-12">
                                 <input class="contactus" placeholder="Phone Number" type="type" name=" phone"
                                     required>
                             </div>
                             <div class="col-md-12">
                                <textarea class="textarea" placeholder="Message" name="message" required></textarea>
                             </div>
                             <div class="col-md-12">
                                 <button type="submit" class="send_btn">Send</button>
                             </div>
                         </div>
                     </form>
                 </div>
                 <div class="col-md-6">
                     <div class="map_main">
                         <div class="map-responsive">
                             <iframe
                                 src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France"
                                 width="600" height="400" frameborder="0" style="border:0; width: 100%;"
                                 allowfullscreen=""></iframe>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
