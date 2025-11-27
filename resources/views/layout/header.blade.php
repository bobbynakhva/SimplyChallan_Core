<!-- ==================== Header Start Here ==================== -->
    <!--Header Section Here -->   

<header class="header-section customize__header border__bottom animated slideInUp">
   <div class="container">
      <div class="header-wrapper">
         <div class="logo-menu">
            <a href="{{ route('flow-tab') }}\" class="logo">
               <img src="{{ asset('assets/img/logo/logo.png') }}" height="100px;" width="120px;" alt="logo">
            </a>
            <a href="{{ route('flow-tab') }}" class="small__logo d-xl-none">
               <img src="{{ asset('assets/img/logo/logo.png') }}" height="100px;" width="120px;" alt="logo">
            </a>
         </div>
         <div class="menu__right__components d-flex align-items-center">
            <div class="sigup__grp d-lg-none">
                @guest
                   <a href="{{ route('login') }}" class="cmn__btn outline__btn">
                      <span>
                         Signin
                      </span>
                   </a>
                   <a href="{{ route('register') }}" class="cmn__btn">
                      <span>
                         Signup
                      </span>
                   </a>
                    @else
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="cmn__btn outline__btn" >
                                <span>
                              {{ __('Logout') }}
                           </span></button>
                    </form>
                    @endguest   
                    </div>
            <div class="header-bar d-lg-none">
               <span></span>
               <span></span>
               <span></span>
            </div>
         </div>
            <ul class="main-menu">
            <li class="grid__style">
              <a href="{{ route('companies.create') }}" class="d-flex">
                  <span>Create Company</span>
                   <!-- <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span> -->
                </a>
             </li>
             <li class="grid__style">
              <a href="{{ route('companies.index') }}" class="d-flex">
                  <span>Company</span>
                   <!-- <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span> -->
                </a>
             </li>
          </ul>
         
        <!-- <ul class="main-menu">
            <li class="grid__style">
               <a href="javascript:void(0)" class="d-flex">
                  <span>
                     Home 
                  </span>
                   <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span>
                </a>
               <ul class="sub-menu">
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           Recharge & Bill Payment
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li class="subtwohober">
                           <a href="index-2.html">Recharge & Bill Payment [1]</a>
                        </li>
                        <li>
                           <a href="index-3.html">Recharge & Bill Payment [2]</a>
                        </li>
                        <li>
                           <a href="index-4.html">Recharge & Bill Payment [3]</a>
                        </li>
                     </ul>
                  </li>
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           Booking Landing
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li>
                           <a href="booking-landing1.html">
                              Booking Landing [1]
                           </a>
                        </li>
                        <li>
                           <a href="booking-landing2.html">
                              Booking Landing [2]
                           </a>
                        </li>
                        <li>
                           <a href="booking-landing3.html">
                              Booking Landing [3]
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="subtwohober">
                     <a href="hotel-book.html">Hotel Booking</a>
                  </li>
                  <li>
                     <a href="flight-book.html">Flight Booking</a>
                  </li>
                  <li>
                     <a href="train-book.html">Train Booking</a>
                  </li>
                  <li>
                     <a href="bus-book.html">Bus Booking</a>
                  </li>
                  <li>
                     <a href="cars-book.html">Car Booking</a>
                  </li>
               </ul>
            </li>
            <li class="grid__style">
               <a href="javascript:void(0)" class="d-flex">
                  <span>
                     Recharge & Bill Payment 
                  </span>
                   <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span>
                </a>
               <ul class="sub-menu submenu__recharge">
                  <li class="subtwohober">
                     <a href="index-2.html">Recharge & Bill Payment [1]</a>
                  </li>
                  <li>
                     <a href="index-3.html">Recharge & Bill Payment [2]</a>
                  </li>
                  <li>
                     <a href="index-4.html">Recharge & Bill Payment [3]</a>
                  </li>
                  <li>
                     <a href="mobile3.html">Mobile</a>
                  </li>
                  <li>
                     <a href="card.html">Card</a>
                  </li>
                  <li>
                     <a href="broadband.html">Broadband</a>
                  </li>
                  <li>
                     <a href="landline.html">Landline</a>
                  </li>
                  <li>
                     <a href="cabletv.html">Cable Tv</a>
                  </li>
                  <li>
                     <a href="electricity.html">Electricity</a>
                  </li>
                  <li>
                     <a href="gas.html">Gas</a>
                  </li>
                  <li>
                     <a href="water.html">Water</a>
                  </li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0)" class="d-flex">
                 <span>
                     Booking 
                 </span>
                  <span class="icons">
                     <i class="material-symbols-outlined">
                        expand_more
                     </i>
                  </span>
               </a>
               <ul class="sub-menu submenu__booking">
                  <li class="d subtwohober">
                     <a href="javascript:void(0)">
                        <span class="fz-18 dtext d-block fw-700 lato">
                           Hotel
                        </span>
                     </a>
                     <a href="hotel-book.html">
                        Hotel Booking
                     </a>
                     <a href="hotel-list.html">
                        Hotel List
                     </a>
                     <a href="hotel-grid.html">
                        Hotel Grid
                     </a>
                     <a href="hotel-details.html">
                        Hotel Details
                     </a>
                     <a href="hotel-details-confirm.html">
                        Confirm Details
                     </a>
                     <a href="hotel-payment.html">
                        Payment
                     </a>
                     <a href="hotel-invoice.html">
                        Invoice
                     </a>
                     <a href="hotel-email.html">
                        Email Template
                     </a>
                  </li>
                  <li class="d">
                     <a href="javascript:void(0)">
                        <span class="fz-18 dtext d-block fw-700 lato">
                           Flight
                        </span>
                     </a>
                     <a href="flight-book.html">
                        Flights Booking
                     </a>
                     <a href="flight-round.html">
                        Flights One Way
                     </a>
                     <a href="flight-oneway.html">
                        Flights Round Trip
                     </a>
                     <a href="flight-confirm-details.html">
                        Confirm Details
                     </a>
                     <a href="flight-payment.html">
                        Flight Payment
                     </a>
                     <a href="flight-invoice.html">
                        Flight Invoice
                     </a>
                     <a href="flight-email.html">
                        Flight Email Template
                     </a>
                  </li>
                  <li class="d">
                     <a href="javascript:void(0)">
                        <span class="fz-18 dtext d-block fw-700 lato">
                           Train
                        </span>
                     </a>
                     <a href="train-book.html">
                        Train Booking
                     </a>
                     <a href="train-list.html">
                        Train List
                     </a>
                     <a href="train-grid.html">
                        Train Grid
                     </a>
                     <a href="train-oneway.html">
                        Train Round Trip
                     </a>
                     <a href="train-bookingsystem.html">
                        Booking System
                     </a>
                     <a href="train-confirm-details.html">
                        Confirm Details
                     </a>
                     <a href="train-payment.html">
                        Train Payment
                     </a>
                     <a href="train-invocie.html">
                        Train Invoice
                     </a>
                     <a href="train-email.html">
                        Train Email Template
                     </a>
                  </li>
                  <li class="d">
                     <a href="javascript:void(0)">
                        <span class="fz-18 dtext d-block fw-700 lato">
                           Bus
                        </span>
                     </a>
                     <a href="bus-book.html">
                        Bus Booking
                     </a>
                     <a href="bus-list.html">
                        Bus List
                     </a>
                     <a href="bus-oneway.html">
                        Round Trip
                     </a>
                     <a href="bus-bookingsystem.html">
                        Bus Booking System
                     </a>
                     <a href="bus-confirm-details.html">
                        Confirm Details
                     </a>
                     <a href="bus-payment.html">
                        Bus Payment
                     </a>
                     <a href="bus-invocie.html">
                        Bus Invoice
                     </a>
                     <a href="bus-email.html">
                        Bus Email Template
                     </a>
                  </li>
                  <li class="d">
                     <a href="javascript:void(0)">
                        <span class="fz-18 dtext d-block fw-700 lato">
                           Car
                        </span>
                     </a>
                     <a href="cars-book.html">
                        Car Booking
                     </a>
                     <a href="car-list.html">
                        Car List
                     </a>
                     <a href="car-grid.html">
                        Car Grid
                     </a>
                     <a href="car-confirm-details.html">
                        Confirm Details
                     </a>
                     <a href="car-payment.html">
                        Car Payment
                     </a>
                     <a href="car-invocie.html">
                        Car Invoice
                     </a>
                     <a href="car-email.html">
                        Car Email Template
                     </a>
                  </li>
               </ul>
            </li>
            <li class="grid__style">
               <a href="javascript:void(0)" class="d-flex">
                  <span>
                     Blog 
                  </span>
                   <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span>
                </a>
               <ul class="sub-menu">
                  <li class="subtwohober">
                     <a href="blog-list.html">Blog List</a>
                  </li>
                  <li><a href="blog-grid.html">Blog Grid</a></li>
                  <li><a href="blog-details.html">Blog Details</a></li>
               </ul>
            </li>
            <li class="grid__style">
               <a href="javascript:void(0)" class="d-flex">
                  <span>
                     Pages 
                  </span>
                   <span class="icons">
                      <i class="material-symbols-outlined">
                         expand_more
                      </i>
                   </span>
                </a>
               <ul class="sub-menu">
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           About
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li>
                           <a href="about.html">
                              About us
                           </a>
                        </li>
                        <li>
                           <a href="chat-us.html">
                              Chat us
                           </a>
                        </li>
                        <li>
                           <a href="favourites.html">
                              Favorites
                           </a>
                        </li>
                        <li>
                           <a href="help.html">
                              Help page
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           Support
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li>
                           <a href="help-support.html">
                             Support
                           </a>
                        </li>
                        <li>
                           <a href="help-knowledge.html">
                              Support Knowledge
                           </a>
                        </li>
                        <li>
                           <a href="help-knowledge-details.html">
                              Support Details
                           </a>
                        </li>
                        <li>
                           <a href="video-tutorial.html">
                              Support Tutorial
                           </a>
                        </li>
                        <li>
                           <a href="submit-ticket.html">
                              Submit Ticket
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           My Profile
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li>
                           <a href="personal-information.html">
                             Personal info
                           </a>
                        </li>
                        <li>
                           <a href="login-security.html">
                              Login Security
                           </a>
                        </li>
                        <li>
                           <a href="favourites.html">
                              Favourites
                           </a>
                        </li>
                        <li>
                           <a href="transaction.html">
                              Transaction
                           </a>
                        </li>
                        <li>
                           <a href="password-change.html">
                              Change Password
                           </a>
                        </li>
                        <li>
                           <a href="notification.html">
                              Notification
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="subtwohober">
                     <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between">
                        <span class="text">
                           Signup & Register
                        </span>
                        <span class="icon">
                           <i class="material-symbols-outlined">
                              add
                           </i>
                        </span>  
                     </a>
                     <ul class="sub-two">
                        <li>
                           <a href="signup.html">
                             Signup Register
                           </a>
                        </li>
                        <li>
                           <a href="password.html">
                              Password Change
                           </a>
                        </li>
                        <li>
                           <a href="number-toreach.html">
                              Signup Number 
                           </a>
                        </li>
                        <li>
                           <a href="varified-number.html">
                              Varified Number 
                           </a>
                        </li>
                        <li>
                           <a href="signin.html">
                              Sign in 
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li><a href="faq.html">Faq Page</a></li>
                  <li><a href="contact.html">Contact</a></li>
                  <li><a href="error.html">404</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0)" class="d-flex">
                 <span>
                     Elements 
                 </span>
                  <span class="icons">
                     <i class="material-symbols-outlined">
                        expand_more
                     </i>
                  </span>
               </a>
               <ul class="sub-menu submenu__element">
                  <li class="subtwohober">
                     <a href="typography.html" class="d-lg-none">Typography</a>
                     <a href="typography.html" class="mh__img">
                        Typography
                     </a>
                  </li>
                  <li>
                     <a href="blocks-home.html" class="d-lg-none">Banner</a>
                     <a href="blocks-home.html" class="mh__img">
                        Banner
                     </a>
                  </li>
                  <li>
                     <a href="blocks-allblocks.html" class="d-lg-none">All Blocks</a>
                     <a href="blocks-allblocks.html" class="mh__img">
                        All Blocks
                     </a>
                  </li>
                  <li>
                     <a href="blocks-ordersystem.html" class="d-lg-none">Order System</a>
                     <a href="blocks-ordersystem.html" class="mh__img">
                        Order System
                     </a>
                  </li>
                  <li>
                     <a href="blocks-about.html" class="d-lg-none">About & Refer</a>
                     <a href="blocks-about.html" class="mh__img">
                        About & Refer
                     </a>
                  </li>
                  <li>
                     <a href="blocks-list.html" class="d-lg-none">Page List</a>
                     <a href="blocks-list.html" class="mh__img">
                        Page List
                     </a>
                  </li>
                  <li class="subtwohober">
                     <a href="blocks-grid.html" class="d-lg-none">Page Grid</a>
                     <a href="blocks-grid.html" class="mh__img">
                        Page Grid
                     </a>
                  </li>
                  <li>
                     <a href="blocks-invoice.html" class="d-lg-none">Invoice/Email</a>
                     <a href="blocks-invoice.html" class="mh__img">
                        Invoice/Email
                     </a>
                  </li>
                  <li>
                     <a href="blocks-signin.html" class="d-lg-none">Sigin/sigup</a>
                     <a href="blocks-signin.html" class="mh__img">
                        Sigin/sigup
                     </a>
                  </li>
                  <li>
                     <a href="blocks-confirm-details.html" class="d-lg-none">Confirm Details</a>
                     <a href="blocks-confirm-details.html" class="mh__img">
                        Confirm Details
                     </a>
                  </li>
                  <li>
                     <a href="blocks-payments.html" class="d-lg-none">Payment System</a>
                     <a href="blocks-payments.html" class="mh__img">
                        Payment System
                     </a>
                  </li>
                  <li>
                     <a href="successful.html" class="d-lg-none">Successful</a>
                     <a href="successful.html" class="mh__img">
                        Successful
                     </a>
                  </li>
                  <li>
                     <a href="blocks-personalinfo.html" class="d-lg-none">Personal Info</a>
                     <a href="blocks-personalinfo.html" class="mh__img">
                        Personal Info
                     </a>
                  </li>
                  <li>
                     <a href="blocks-testimonial.html" class="d-lg-none">Testimonial</a>
                     <a href="blocks-testimonial.html" class="mh__img">
                        Testimonial
                     </a>
                  </li>
                  <li>
                     <a href="blocks-faqs.html" class="d-lg-none">Faq</a>
                     <a href="blocks-faqs.html" class="mh__img">
                        Faq
                     </a>
                  </li>
                  <li>
                     <a href="blocks-support.html" class="d-lg-none">Support</a>
                     <a href="blocks-support.html" class="mh__img">
                        Support
                     </a>
                  </li>
                  <li>
                     <a href="blocks-contact.html" class="d-lg-none">Contact Us</a>
                     <a href="blocks-contact.html" class="mh__img">
                        Contact Us
                     </a>
                  </li>
                  <li>
                     <a href="blocks-error.html" class="d-lg-none">Error</a>
                     <a href="blocks-error.html" class="mh__img">
                        Error
                     </a>
                  </li>
               </ul>
            </li>
            <li class="sigup__grp d-lg-none d-flex align-items-center">
               <a href="signin.html" class="cmn__btn outline__btn">
                  <span>
                     Signin
                  </span>
               </a>
               <a href="signup.html" class="cmn__btn">
                  <span>
                     Signup
                  </span>
               </a>
            </li>
        </ul> -->
         <div class="sigin__grp d-flex align-items-center">
            @guest
                   <a href="{{ route('login') }}" class="cmn__btn outline__btn">
                      <span>
                         Signin
                      </span>
                   </a>
                   <a href="{{ route('register') }}" class="cmn__btn">
                      <span>
                         Signup
                      </span>
                   </a>
                    @else
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="cmn__btn outline__btn" >
                                <span>
                              {{ __('Logout') }}
                           </span></button>
                    </form>
                    @endguest   
         </div>
      </div>
   </div>
</header>
<!-- Header top End -->
    <!-- ==================== Header End Here ==================== -->