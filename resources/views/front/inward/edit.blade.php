@extends('layout-inward.app')
@section('title', 'Edit Inward Challan')
@section('content')
<style>
    @media (max-width: 768px) {
        #mobile_text {
            text-align: center !important;
        }
    }
</style>

<div class="common__section">
    <div class="container-fluid">
        <div class="divided__common__body">
            @include('layout-inward.sidebar')

            <div class="common__body">
                <h4 id="mobile_text">Edit Inward Challan</h4>
                <div class="common__body__section pb-5">
                    <section class="contact__section pt-4 pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="card p-4 shadow-sm">
                                        <form action="{{ route('inward.challan.update', $challan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row g-4">
                                                <!-- Company Dropdown -->
                                                <div class="col-md-4">
                                                    <label for="company_id" class="form-label">Select Client</label>
                                                    <select name="company_id" id="company_id" class="form-select" required>
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}" {{ $company->id == $challan->company_id ? 'selected' : '' }}>
                                                                {{ $company->industry_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Challan Number -->
                                                <div class="col-md-4">
                                                    <label for="challan_number" class="form-label">Challan Number</label>
                                                    <input type="text" name="challan_number" value="{{ $challan->challan_number }}" class="form-control" readonly>
                                                </div>

                                                <div class="col-lg-4">
                                                        <label for="main_challan_number" class="form-label">Main Challan Number</label>
                                                        <input type="text" name="main_challan_number" value="{{ $challan->main_challan_number }}" readonly class="form-control">
                                                        @error('main_challan_number')
                                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                </div>

                                                <!-- Date -->
                                               <div class="col-md-4">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" name="date" 
                                                        value="{{ old('date', optional($challan->date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" 
                                                        class="form-control">
                                                </div>


                                                <!-- Purpose -->
                                                <div class="col-md-4">
                                                    <label for="purpose_id" class="form-label">Purpose</label>
                                                    <select name="purpose_id" id="purpose" class="form-select" required>
                                                        <option value="">Select Purpose</option>
                                                        @foreach(\App\Models\Purpose::all() as $purpose)
                                                            <option value="{{ $purpose->id }}" {{ $challan->purpose_id == $purpose->id ? 'selected' : '' }}>
                                                                {{ $purpose->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Industry Details -->
                                                <input type="hidden" name="industry_name" value="{{ $challan->industry_name }}">
                                                <div class="col-md-4">
                                                    <label class="form-label">Client Number</label>
                                                    <input type="text" name="industry_number" value="{{ $challan->industry_number }}" class="form-control" readonly>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Client GST Number</label>
                                                    <input type="text" name="industry_gstin" value="{{ $challan->industry_gstin }}" class="form-control" readonly>
                                                </div>

                                                <!-- Items Section -->
                                                <div class="col-12 mt-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="mb-0">Challan Items</h5>
                                                        <button type="button" class="btn btn-sm btn-success" id="addItemBtn">+ Add Item</button>
                                                    </div>
                                                    <div id="itemsContainer">
                                                        @foreach($challan->inwarditems as $index => $item)
                                                            <div class="row g-2 item-row mb-2">
                                                                <div class="col-md-3">
                                                                    <input type="text" name="inwarditems[{{ $index }}][item_name]" value="{{ $item->item_name }}" class="form-control" placeholder="Item Name" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number" name="inwarditems[{{ $index }}][qty]" value="{{ $item->qty }}" class="form-control qty" step="0.00001" placeholder="Qty (KG)" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number" name="inwarditems[{{ $index }}][piece_no]" value="{{ $item->piece_no }}" class="form-control" placeholder="Piece No.">
                                                                </div>
                                                                <div class="col-lg-3 d-flex align-items-end"><button type="button" class="btn btn-danger removeItemBtn">X</button></div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Totals -->
                                                <div class="col-md-4">
                                                    <label class="form-label">Total Qty</label>
                                                    <input type="number" name="total_qty" value="{{ $challan->total_qty }}" id="total_qty" step="0.01" class="form-control" readonly>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Update Challan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- card -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div><!-- section -->
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
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
                       // Fill in the fields with the returned data
                       $('#industry_name').val(response.industry_name);
                       $('#industry_number').val(response.industry_number);
                       $('#industry_gstin').val(response.industry_gstin);
                       $('#industry_address').val(response.industry_address);
                   },
                   error: function() {
                       alert('Company details not found!');
                   }
               });
           } else {
               // Clear fields if no company selected
               $('#industry_name').val('');
               $('#challan_number').val('');
               $('#address').val('');
           }
       });
   });
   $(document).ready(function () {
    // Set itemIndex based on how many existing items you have
    let itemIndex = $('#itemsContainer .item-row').length;

    // Function: Calculate total for a single item row
    function calculateItemTotal(row) {
        let price = parseFloat(row.find('.price-per-kg').val()) || 0;
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let total = price * qty;

        row.find('.total-value').val(total.toFixed(2));
    }

    // Function: Calculate total value sum + taxes + grand total
    function calculateAllTotals() {
        let totalValueSum = 0;

        // Loop through each total-value field and sum
        $('.total-value').each(function () {
            totalValueSum += parseFloat($(this).val()) || 0;
        });

        let cgstRate = parseFloat($('#cgst').val()) || 0;
        let sgstRate = parseFloat($('#sgst').val()) || 0;

        let cgstAmount = (totalValueSum * cgstRate) / 100;
        let sgstAmount = (totalValueSum * sgstRate) / 100;

        let totalTax = cgstAmount + sgstAmount;
        let grandTotal = totalValueSum + totalTax;

        $('#total_tax').val(totalTax.toFixed(2));
        $('#grand_total').val(grandTotal.toFixed(2));
    }

    // Function: Recalculate all rows on page load
    function recalculateExistingRows() {
        $('#itemsContainer .item-row').each(function () {
            calculateItemTotal($(this));
        });
        calculateAllTotals();
    }

    // Add Item button click event
    $('#addItemBtn').on('click', function () {
        const container = $('#itemsContainer');

        const newItemRow = `
            <div class="row g-3 item-row mb-2">
            <div class="col-lg-3"><input type="text" name="inwarditems[${itemIndex}][item_name]" class="form-control" placeholder="Item Name" required></div>
            <div class="col-lg-3"><input type="number" name="inwarditems[${itemIndex}][qty]" step="0.00001" class="form-control qty" placeholder="Qty (KG)" required></div>
            <div class="col-lg-3"><input type="number" name="inwarditems[${itemIndex}][piece_no]" class="form-control piece_no" placeholder="Piece No."></div>
            <div class="col-lg-3 d-flex align-items-end"><button type="button" class="btn btn-danger removeItemBtn">X</button></div>
        </div>`;

        container.append(newItemRow);
        itemIndex++;
    });

    // Remove item row and recalculate
    $('#itemsContainer').on('click', '.removeItemBtn', function () {
        $(this).closest('.item-row').remove();
        calculateAllTotals();
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

});

   
</script>
@endpush
@endsection