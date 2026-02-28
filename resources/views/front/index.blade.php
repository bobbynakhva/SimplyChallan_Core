@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Customization */
    .select2-container .select2-selection--single {
        height: 54px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        background-color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.2s ease !important;
        padding-left: 10px !important;
    }

    .select2-container .select2-selection--single:hover {
        border-color: #c7d2fe !important;
    }

    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 52px !important;
        width: 30px !important;
        right: 10px !important;
    }

    .select2-dropdown {
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        overflow: hidden !important;
        margin-top: 8px !important;
    }

    .select2-results__option {
        padding: 10px 15px !important;
        font-size: 0.95rem !important;
        color: #1f2937 !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #6366f1 !important;
        color: white !important;
    }

    /* Card Container */
    .signup__boxes {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 3rem !important;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .signup__boxes h4 {
        color: #1f2937;
        font-family: 'Inter', sans-serif;
        font-weight: 800 !important;
        margin-bottom: 0.5rem;
    }

    .input__grp label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
    }

    /* Button Styling */
    .cmn__btn {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%) !important;
        color: white !important;
        padding: 14px 28px !important;
        border-radius: 12px !important;
        border: none !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
        width: 100%;
        display: block; 
        position: relative;
        overflow: hidden;
    }

    .cmn__btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3) !important;
        color: white !important;
    }

    .cmn__btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Entry Animation */
    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .signup__boxes {
        animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Refined Background */
    body {
        background: url('{{ asset("assets/images/login-bg.jpg") }}') no-repeat center center fixed; 
        background-size: cover;
    }
    /* Fallback/Overlay */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, #f3e8ff 0%, #e0e7ff 100%);
        z-index: -1;
        opacity: 0.8; 
    }
</style>

<section class="signup__section" style="min-height: 100vh; display: flex; align-items: center;">
   <div class="container">
         <div class="row justify-content-center">
                              <div class="col-xl-6 col-lg-6">
                                 <div class="signup__boxes">
                                   <h4 class="text-center fw-bold">Select Company & Financial Year</h4>
               
                                    <form action="{{ route('company.select') }}" method="POST" class="signup__form pt__40" id="selectionForm">
                                       @csrf

                                       <div class="row g-4 justify-content-center">
               
                                        <div class="col-lg-12">
                                             <div class="input__grp">
                                                <label for="company_id">Select Company</label>
                                                <select name="company_id" id="company_id" class="form-control select2-search" required>
                                                    <option value="">Select a Company...</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('company_id')
                                                  <span class="invalid-feedback" role="alert" style="display:block">
                                                     <strong>{{ $message }}</strong>
                                                  </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input__grp">
                                                <label for="financial_year" class="form-label">Select Financial Year</label>
                                               <select name="financial_year" id="financial_year" class="form-select select2-search" required>
                                                    <option value="">-- Choose Financial Year --</option>
                                                    @foreach($financial_years as $year)
                                                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                                                    @endforeach
                                                </select>
                                                @error('financial_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                     <div class="col-lg-12">
                                        <div class="input__grp text-center">
                                          <button type="submit" class="cmn__btn" id="accessBtn">
                                              <span>Access Dashboard</span>
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
@push('scripts')
<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- FontAwesome for Spinner -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-search').select2({
        width: '100%',
        placeholder: "Select an option",
        allowClear: true
    });

    // Auto-focus the company dropdown for immediate interaction
    setTimeout(function() {
        $('#company_id').select2('open');
    }, 300);

    // Form Loading State
    $('#selectionForm').on('submit', function() {
        let btn = $('#accessBtn');
        btn.prop('disabled', true);
        btn.html('<span><i class="fa-solid fa-spinner fa-spin"></i> Accessing...</span>');
    });
});
</script>
@endpush
@endsection