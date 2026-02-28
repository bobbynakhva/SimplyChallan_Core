@extends('layouts.app')
@section('title', 'Register')
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
    .sign__already p {
        color: #718096;
        margin-top: 20px;
        font-size: 15px;
        text-align: center;
    }
    .sign__already a {
        color: #4154B9 !important;
        font-weight: 600;
        transition: color 0.2s;
    }
    .sign__already a:hover {
        color: #2840BF !important;
        text-decoration: underline;
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
