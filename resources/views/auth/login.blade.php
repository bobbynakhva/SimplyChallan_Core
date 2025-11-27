@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="signup__section bluar__shape">
   <div class="container">
         <div class="row justify-content-center">
                              <div class="col-xl-6 col-lg-6">
                                 <div class="signup__boxes">
                                   <h4 class="text-center fw-bold">Sign in to Simply Challan App</h4>
               <p class="text-center text-muted">Sign in to your account and make Simply Challan payments and bookings faster.</p>
               
                                    <form action="{{ route('loginpost') }}" method="POST" class="signup__form pt__40">
                                       @csrf
                                       <div class="row g-4 justify-content-center">
               
                 <div class="col-lg-12">
                                             <div class="input__grp">
                           <label for="email">Enter Your Email ID</label>
                           <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your email ID here" value="{{ old('email') }}" required autocomplete="email" autofocus>
                           @error('email')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-12">
                                             <div class="input__grp">
                           <label for="password">Enter Your Password</label>
                           <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required autocomplete="current-password">
                           @error('password')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>
                     @if (Route::has('password.request'))
                        <div class="col-lg-12">
                           <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
                        </div>
                     @endif
                     <div class="col-lg-12">
                        <div class="input__grp text-center">
                          <button type="submit" class="cmn__btn">
                              <span>Sign In</span>
                          </button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection