     <div class="contact" id="contact">
         <div class="container">
             <div class="row">
                 <div class="col-md-12">
                     <div class="titlepage">
                         <h2>Contact Us</h2>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-6">
                     <form id="request" class="main_form" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                         <div class="row">
                             <div class="col-md-12 ">
                                 <input class="contactus" placeholder="Name" required type="text" name="name"
                                     value="{{ old('name') }}">
                             </div>
                             <div class="col-md-12">
                                 <input class="contactus" placeholder="Email" type="email" name="email" required
                                     value="{{ old('email') }}">
                             </div>
                             <div class="col-md-12">
                                 <input class="contactus" placeholder="Phone Number" type="tel" name="phone"
                                     required value="{{ old('phone') }}">
                             </div>
                             <div class="col-md-12">
                                <textarea class="textarea" placeholder="Message" name="message" required>{{ old('message') }}</textarea>
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
                                 src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.99162569376!2d2.2922926!3d48.8583701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sEiffel%20Tower!5e0!3m2!1sen!2sfr!4v1"
                                 width="600" height="400" style="border:0; width: 100%;"
                                 allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
