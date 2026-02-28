@extends('layout.app')

@section('title', 'Select Company')

@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 50px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
            display: flex !important;
            align-items: center !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px !important;
        }
        .contact__form {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>

    <section class="contact__form">
        <div class="contact__bg"><img src="{{ asset('assets/images/yellow-sp.png') }}" alt="img"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact__form__title text-center mb-5" data-aos="zoom-in-up">
                        <h2>Select Company & Financial Year</h2>
                         @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact__form__main p-5 shadow bg-white rounded">
                        <form action="{{ route('company.select') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="contact__form__main__single">
                                        <label for="company_id" class="form-label fw-bold mb-2">Select Company</label>
                                        <select name="company_id" id="company_id" class="form-control select2-search" required>
                                            <option value="">Select a Company...</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="contact__form__main__single">
                                        <label for="financial_year" class="form-label fw-bold mb-2">Select Financial Year</label>
                                        <select name="financial_year" id="financial_year" class="form-control select2-search" required>
                                            <option value="">Select Financial Year...</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}" {{ $loop->last ? 'selected' : '' }}>{{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="common__btn w-100" style="max-width: 200px;">
                                        <span>Access Dashboard</span>
                                        <span><i class="fa-solid fa-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-search').select2({
                width: '100%',
                placeholder: "Type to search...",
                allowClear: true
            });
        });
    </script>
@endsection