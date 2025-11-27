@extends('layout.app')
@section('title', 'Edit Company')
@section('content')
<section class="signup__section bluar__shape">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-12 col-lg-12">
            <div class="signup__boxes">
               <h4 class="text-center fw-bold">Edit Company</h4>
               <form action="{{ route('companies.update', $company->id) }}" method="POST" class="signup__form pt__40">
                  @csrf
                  @method('PUT')
                  <div class="row g-4 justify-content-center">
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="industry_name" class="form-label form--label">Client Name</label>
                           <input type="text" class="form--control @error('industry_name') is-invalid @enderror"
                              id="industry_name" name="industry_name" value="{{ old('industry_name', $company->industry_name) }}" placeholder="Enter client Industry name">
                           @error('industry_name')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="industry_number" class="form-label form--label">Client Number</label>
                           <input type="text" value="{{ old('industry_number', $company->industry_number) }}" class="form--control @error('industry_number') is-invalid @enderror"
                              id="industry_number" name="industry_number" placeholder="Enter client Industry number">
                           @error('industry_number')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="industry_gstin" class="form-label form--label">Client GST Number</label>
                           <input type="text" 
                              class="form--control @error('industry_gstin') is-invalid @enderror" 
                              id="industry_gstin" 
                              name="industry_gstin" 
                              placeholder="Enter GST Number" 
                              value="{{ old('industry_gstin', $company->industry_gstin) }}"
                              pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$" 
                              title="Please enter a valid GST number (e.g. 11AAAAA0000A1Z5)">
                           @error('industry_gstin')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input__grp">
                           <label for="industry_address" class="form-label form--label">Client Address</label>
                              <textarea class="form--control @error('industry_address') is-invalid @enderror" id="industry_address"
                              name="industry_address" placeholder="Type client Industry address">{{ old('industry_address', $company->industry_address) }}</textarea>
                           @error('industry_address')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="input__grp mt-2 text-center">
                           <button type="submit" class="cmn__btn">
                           <span>Update Now</span>
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
