@extends('layouts.app')
@section('title', 'Create Company')
@section('content')
@push('styles')
<style>
    .signup__section {
        background-color: #f8f9fa; /* Light background for contrast */
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 60px 0;
    }
    .signup__boxes {
        background: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.02);
    }
    .signup__boxes h4 {
        color: #1a1a1a;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 28px;
    }
    .input__grp label {
        font-weight: 500;
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        height: 50px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        padding: 10px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        color: #2d3748;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #4154B9; /* Using base color */
        box-shadow: 0 0 0 4px rgba(65, 84, 185, 0.1);
    }
    .form-control::placeholder {
        color: #a0aec0;
    }
    textarea.form-control {
        height: auto;
    }
    .cmn__btn {
        width: 100%;
        height: 54px;
        border-radius: 12px;
        background: linear-gradient(135deg, #4154B9 0%, #2840BF 100%);
        color: white;
        font-weight: 600;
        font-size: 16px;
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cmn__btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(65, 84, 185, 0.3);
        background: linear-gradient(135deg, #3748a8 0%, #2439a8 100%);
        color: white;
    }
    .invalid-feedback {
        font-size: 13px;
        margin-top: 6px;
    }
</style>
@endpush
<section class="signup__section bluar__shape">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-8 col-lg-8">
            <div class="signup__boxes">
               <h4 class="text-center fw-bold">Create Company</h4>
               <form action="{{ route('urcompanies.store') }}" method="POST" class="signup__form pt__40">
                  @csrf
                  <div class="row g-4 justify-content-center">
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="name">Name</label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror"
                              id="name" name="name" placeholder="Enter Company name" value="{{ old('name') }}">
                           @error('name')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>


                     
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="gstin">GST Number</label>
                           <input type="text" 
                              class="form-control @error('gstin') is-invalid @enderror" 
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
                           <label for="address">Address</label>
                              <textarea class="form-control @error('address') is-invalid @enderror" id="address" rows="3"
                              name="address" placeholder="Type Company address" maxlength="100">{{ old('address') }}</textarea>
                           @error('address')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-lg-12">
                        <div class="input__grp mt-4 text-center">
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