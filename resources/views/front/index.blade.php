@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="signup__section bluar__shape">
   <div class="container">
         <div class="row justify-content-center">
                              <div class="col-xl-6 col-lg-6">
                                 <div class="signup__boxes">
                                   <h4 class="text-center fw-bold">Select Company & Financial Year</h4>
               
                                    <form action="{{ route('company.select') }}" method="POST" class="signup__form pt__40">
                                       @csrf

                                       <div class="row g-4 justify-content-center">
               
                                        <div class="col-lg-12">
                                             <div class="input__grp">
                                                <label for="password">Select Company</label>
                                                <input type="text" id="company" name="company" class="form-control @error('company') is-invalid @enderror" placeholder="Start typing company name..." autocomplete="off">
                                                <input type="hidden" id="company_id" name="company_id">
                                                    <div id="companySuggestions" class="list-group"></div>
                                                @error('company')
                                                  <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                  </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input__grp">
                                                <label for="challan_no" class="form-label">Select Financial Year</label>
                                               <select name="financial_year" id="financial_year" class="form-select @error('financial_year') is-invalid @enderror">
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
                                          <button type="submit" class="cmn__btn">
                                              <span>Access</span>
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
<script>
$(document).ready(function() {
    $('#company').on('keyup', function() {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('company.search') }}",
                type: "GET",
                data: { query: query },
                success: function(data) {
                    $('#companySuggestions').empty();
                    data.forEach(company => {
                        $('#companySuggestions').append(`<a href="#" class="list-group-item list-group-item-action company-option" data-id="${company.id}">${company.name}</a>`);
                    });
                }
            });
        } else {
            $('#companySuggestions').empty();
        }
    });

    $(document).on('click', '.company-option', function() {
        $('#company').val($(this).text());
        $('#company_id').val($(this).data('id'));
        $('#companySuggestions').empty();
    });
});
</script>
@endpush
@endsection