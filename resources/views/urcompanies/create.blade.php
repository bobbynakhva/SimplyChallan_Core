@extends('layouts.app')
@section('title', 'Create Company')
@section('content')
<section class="signup__section bluar__shape">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-12 col-lg-12">
            <div class="signup__boxes">
               <h4 class="text-center fw-bold">Create Company</h4>
               <form action="{{ route('urcompanies.store') }}" method="POST" class="signup__form pt__40">
                  @csrf
                  <div class="row g-4 justify-content-center">
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="name" class="form-label form--label">Name</label>
                           <input type="text" class="form--control @error('name') is-invalid @enderror"
                              id="name" name="name" placeholder="Enter Company name">
                           @error('name')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>

                    <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="email" class="form-label form--label">Email</label>
                           <input type="text" class="form--control @error('email') is-invalid @enderror"
                              id="email" name="email" placeholder="Enter Company number">
                           @error('email')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="phone" class="form-label form--label">Number</label>
                           <input type="text" class="form--control @error('phone') is-invalid @enderror"
                              id="phone" name="phone" placeholder="Enter Company number">
                           @error('phone')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
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
                     <div class="col-lg-12">
                        <div class="input__grp">
                           <label for="address" class="form-label form--label">Address</label>
                              <textarea class="form--control @error('address') is-invalid @enderror" id="address"
                              name="address" placeholder="Type Company address"></textarea>
                           @error('address')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-lg-12">
                        <div class="input__grp mt-2 text-center">
                           <button type="submit" class="cmn__btn">
                           <span>
                           Submit Now
                           </span>
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