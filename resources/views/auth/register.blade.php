@extends('layouts.app')
@section('title', 'Register')
@section('content')
<section class="signup__section bluar__shape">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-6 col-lg-6">
            <div class="signup__boxes">
                <h4 class="text-center fw-bold">Sign Up to Simply Challan App</h4>
               <form action="{{ route('registerdata') }}" method="POST" class="signup__form pt__40">
                @csrf
                  <div class="row g-4 justify-content-center">

                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="fname">Name</label>
                           <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                              id="inputFirstName" value="{{ old('name') }}" placeholder="Enter Name" >
                           @error('name')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="email">Email</label>
                           <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your email ID here" value="{{ old('email') }}">
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="gstin" class="form-label form--label">GST Number</label>
                           <input type="text" 
                              class="form--control @error('gstin') is-invalid @enderror" 
                              id="gstin" 
                              name="gstin" 
                              placeholder="Enter GST Number"
                              value="{{ old('gstin') }}" 
                              pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$" 
                              title="Please enter a valid GST number (e.g. 11AAAAA0000A1Z5)">
                           @error('gstin')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="numm">Phone</label>
                           <input type="number" class="form-control @error('email') is-invalid @enderror"
                              id="inputphone" placeholder="Enter Phone Number " name="phone" value="{{ old('phone') }}" >
                           @error('phone')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="subtest">Password</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror"
                              id="inputPassword" name="password" placeholder="Enter password">
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="subtest">Re - Password</label>
                           <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                              id="inputpassword_confirmation" name="password_confirmation" placeholder="Enter password_confirmation">
                           @error('password_confirmation')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-12">
                         <div class="input__grp">
                            <label for="address">Address</label>
                            <textarea class="" rows="3" id="address" name="address" placeholder="Your message..."></textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                      </div>
                     <div class="col-lg-12">
                        <div class="input__grp mt-2 text-center">
                           <button type="submit" class="cmn__btn">
                           <span>
                           Sign Up
                           </span>
                           </button>
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="sign__already">
                           <p>Already have an account? <a href="{{ route('login') }}" style="color: #000;">Sign In</a></p>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<script>
    document.getElementById('role').addEventListener('change', function () {
        let adminSelection = document.getElementById('adminSelection');
        if (this.value === 'company') {
            adminSelection.style.display = 'block';
        } else {
            adminSelection.style.display = 'none';
        }
    });
</script>
@endsection
