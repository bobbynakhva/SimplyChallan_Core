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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="financial_year" class="form-label fw-bold mb-0">Select Financial Year</label>
                                            <a href="javascript:void(0)" id="toggleAddFYBtn" class="text-primary fw-bold text-decoration-none" style="font-size: 0.85rem;">
                                                <i class="fa-solid fa-plus-circle me-1"></i> Add New FY
                                            </a>
                                        </div>
                                        <select name="financial_year" id="financial_year" class="form-control select2-search" required>
                                            <option value="">Select Financial Year...</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}" {{ $loop->last ? 'selected' : '' }}>{{ $year->year }}</option>
                                            @endforeach
                                        </select>

                                        <!-- Collapsible Add Financial Year Form -->
                                        <div id="addFYPanel" class="mt-3 p-3 bg-light rounded border" style="display: none;">
                                            <h6 class="fw-bold mb-2 text-dark" style="font-size: 0.9rem;"><i class="fa-solid fa-calendar-plus me-1 text-primary"></i> Add New Financial Year</h6>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" id="new_fy_input" class="form-control" placeholder="e.g. 2026-2027 or 2026">
                                                <button type="button" id="saveFYBtn" class="btn btn-primary px-3 fw-semibold">
                                                    <i class="fa-solid fa-check me-1"></i> Add
                                                </button>
                                            </div>
                                            <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">Format: YYYY-YYYY (e.g. 2026-2027) or enter start year (e.g. 2026)</small>
                                            <div id="fyAlertMsg" style="display: none;"></div>
                                        </div>
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

            // Toggle Add FY Panel
            $('#toggleAddFYBtn').on('click', function(e) {
                e.preventDefault();
                $('#addFYPanel').slideToggle(200, function() {
                    if ($(this).is(':visible')) {
                        $('#new_fy_input').focus();
                    }
                });
            });

            // Save New FY via AJAX
            $('#saveFYBtn').on('click', function(e) {
                e.preventDefault();
                let yearVal = $('#new_fy_input').val().trim();
                let alertBox = $('#fyAlertMsg');
                let btn = $(this);

                if (!yearVal) {
                    alertBox.removeClass().addClass('alert alert-warning py-1 px-2 mb-0').html('<small>Please enter a financial year (e.g., 2026-2027)</small>').show();
                    return;
                }

                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

                $.ajax({
                    url: "{{ route('financial-years.store') }}",
                    type: "POST",
                    data: {
                        year: yearVal,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-check me-1"></i> Add');
                        if (response.success) {
                            let newOption = new Option(response.financial_year.year, response.financial_year.id, true, true);
                            $('#financial_year').append(newOption).trigger('change');
                            $('#new_fy_input').val('');
                            alertBox.removeClass().addClass('alert alert-success py-1 px-2 mb-0').html('<small>' + response.message + '</small>').show();
                            setTimeout(function() {
                                $('#addFYPanel').slideUp();
                                alertBox.hide();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-check me-1"></i> Add');
                        let errorMsg = 'Failed to add financial year.';
                        if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.year) {
                            errorMsg = xhr.responseJSON.errors.year[0];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alertBox.removeClass().addClass('alert alert-danger py-1 px-2 mb-0').html('<small>' + errorMsg + '</small>').show();
                    }
                });
            });
        });
    </script>
@endsection