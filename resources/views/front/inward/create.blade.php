@extends('layout-inward.app')

@section('title', 'Create Challan')

@push('styles')
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" /> -->
<style>
    @media (max-width: 768px) {
        #mobile_text {
            text-align: center !important;
        }
    }
</style>
@endpush
@section('content')
<div class="common__section">
    <div class="container-fluid">
        <div class="divided__common__body">
            @include('layout-inward.sidebar')
            <div class="common__body">
                <h4 id="mobile_text">Create Inward Challan</h4> 

                <div class="common__body__section pb__60">
                    <section class="contact__section pt-30 pb-120">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="signup__boxes">
                                        <form class="signup__form pt__10" action="{{ route('inward.challan.store') }}" method="POST">
                                            @csrf
                                            <div class="row g-4 justify-content-center">
                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label for="company_id">Select Client</label>
                                                        <select name="company_id" id="company_id" required class="form-control">
                                                            <option value="">Select Company</option>
                                                            @foreach($companies as $company)
                                                                <option value="{{ $company->id }}" {{ $company->id == $selectedclient->id ? 'selected' : '' }}>
                                                                    {{ $company->industry_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label for="challan_number">Challan Number</label>
                                                        <input type="text" name="challan_number" value="{{ old('challan_number', $challan_no) }}" class="form-control" readonly>
                                                        @error('challan_number')
                                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div> -->

                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label for="main_challan_number">Main Challan Number</label>
                                                        <input type="text" name="main_challan_number"  class="form-control">
                                                        @error('main_challan_number')
                                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label for="date">Date</label>
                                                        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="form-control">
                                                        @error('date')
                                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label for="purpose_id">Purpose</label>
                                                        <select name="purpose_id" id="purpose" class="form-control  " required>
                                                            <option value="">Select Purpose</option>
                                                            @foreach($purposes as $purpose)
                                                                <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('purpose_id')
                                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" id="industry_name" name="industry_name" value="{{ $selectedclient->industry_name ?? '' }}">
                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label>Client Number</label>
                                                        <input type="text" id="industry_number" name="industry_number" value="{{ $selectedclient->industry_number ?? '' }}" readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                        <label>Client GST Number</label>
                                                        <input type="text" id="industry_gstin" name="industry_gstin" value="{{ $selectedclient->industry_gstin ?? '' }}" readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input__grp">
                                                    <label>Total Qty</label>
                                                    <input type="number" step="0.01" name="total_qty" id="total_qty" class="form-control" readonly>
                                                </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h5>Challan Items</h5>
                                                        <button type="button" class="btn btn-sm btn-success" id="addItemBtn">+ Add Item</button>
                                                    </div>
                                                    <div id="itemsContainer">
                                                        <div class="row g-3 item-row mb-2">
                                                            <div class="col-lg-3">
                                                                <input type="text" name="inwarditems[0][item_name]" class="form-control" placeholder="Item Name" required>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="number" name="inwarditems[0][qty]" step="0.00001" class="form-control qty" placeholder="Qty (Kgs)" required>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="number" name="inwarditems[0][piece_no]" class="form-control piece_no" placeholder="Piece No.">
                                                            </div>
                                                            <div class="col-lg-3 d-flex align-items-end">
                                                                <button type="button" class="btn btn-danger removeItemBtn">X</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 text-center mt-3">
                                                    <button type="submit" class="cmn__btn"><span>Save Challan</span></button>
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
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script>
$(document).ready(function() {

    $('#company_id').on('change', function() {
        var companyId = $(this).val();
        if (companyId) {
            $.ajax({
                url: "{{ route('get.company.details') }}",
                type: "GET",
                data: { id: companyId },
                success: function(response) {
                    $('#industry_name').val(response.industry_name);
                    $('#industry_number').val(response.industry_number);
                    $('#industry_gstin').val(response.industry_gstin);
                },
                error: function() {
                    alert('Company details not found!');
                }
            });
        } else {
            $('#industry_name, #industry_number, #industry_gstin').val('');
        }
    });

   function calculateqts() {
    let totalQty = 0;
    $('.qty').each(function () {
        let val = parseFloat($(this).val()) || 0;
        totalQty += val;
    });
    $('#total_qty').val(totalQty.toFixed(2));
}

function calculatepices() {
    let totalPieces = 0;
    $('.piece_no').each(function () {
        let val = parseFloat($(this).val()) || 0;
        totalPieces += val;
    });
    $('#piece_total').val(totalPieces.toFixed(2));
}

// Recalculate on input change
$('#itemsContainer').on('input', '.piece_no, .qty', function () {
    calculatepices();
    calculateqts();
});

    // Add Item
    let itemIndex = 1;
    $('#addItemBtn').click(function() {
        let itemHtml = `
        <div class="row g-3 item-row mb-2">
            <div class="col-lg-3"><input type="text" name="inwarditems[${itemIndex}][item_name]" class="form-control" placeholder="Item Name" required></div>
            <div class="col-lg-3"><input type="number" name="inwarditems[${itemIndex}][qty]" step="0.00001" class="form-control qty" placeholder="Qty (KG)" required></div>
            <div class="col-lg-3"><input type="number" name="inwarditems[${itemIndex}][piece_no]" class="form-control piece_no" placeholder="Piece No."></div>
            <div class="col-lg-3 d-flex align-items-end"><button type="button" class="btn btn-danger removeItemBtn">X</button></div>
        </div>`;
        $('#itemsContainer').append(itemHtml);
        itemIndex++;
    });

    // Remove Item
    $(document).on('click', '.removeItemBtn', function() {
        $(this).closest('.item-row').remove();
    });
});
</script>
@endpush
