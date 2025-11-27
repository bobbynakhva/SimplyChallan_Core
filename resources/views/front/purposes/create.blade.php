@extends('layout.app')
@section('title', 'Create Purpose')
@section('content')
@push('styles')
<!-- Select2 Theme-Compatible CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css">
@endpush

<style type="text/css">
   @media (max-width: 768px) {
   #mobile_text {
   text-align: center !important;
   }
   }
</style>
<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         <div class="side__sticky">
            <ul class="common__sidebar__wrapper">
               <li class="common__sideitems">
                  <a href="{{ route('dashboard') }}" >
                  Manage challan
                  </a>
               </li>
               <li class="common__sideitems" >
                  <a href="{{ route('challan.create') }}" >
                  New challan
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('challan.inward') }}">
                  Inward challan
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('challan.reports') }}">
                  Reports
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('purposes.index') }}" class="active">
                  New Purpose
                  </a>
               </li>
            </ul>
         </div>
         <div class="common__body">
            <h2 class="cmn__title" id="mobile_text">
               Add Purpose
            </h2>
            <!--home one-->
            <div class="common__body__section pb__60">
               <div class="common__body__head pb__20">
                  <!-- <h4>
                     Challan
                     </h4> -->
                  <section class="contact__section pt-30 pb-120">
                     <div class="container">
                        <div class="row justify-content-center wow fadeInDown">
                           <div class="col-lg-12">
                              <div class="section__header section__center pb__60">
                                 <!--<h4 class="text-center" id="mobile_text">
                                    Create Challan
                                    </h4>
                                    <p>
                                    Fill up the form and our team will get back to you within 24 hours
                                    </p> -->
                              </div>
                           </div>
                        </div>
                        <div class="row justify-content-center">
                           <div class="col-xl-12 col-lg-12">
                              <div class="signup__boxes">
                                 <form class="signup__form pt__10" action="{{ route('purposes.store') }}" method="POST">
                                    @csrf
                                    <div class="row g-4 justify-content-center">
                                       
                                       <div class="col-lg-12">
                                          <div class="input__grp">
                                             <label for="name">Purpose Name</label>
                                             <input type="text" name="name" class="">
                                             @error('name')
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
                                             Save Purpose
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
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection