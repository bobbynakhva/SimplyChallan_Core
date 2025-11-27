@extends('layout.app')
@section('title', 'Create Challan')
@section('content')
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
      <a href="{{ route('challan.create') }}" class="active">
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
                  <a href="{{ route('purposes.index') }}">
                  New Purpose
                  </a>
               </li>
   </ul>
</div>
<div class="common__body">
   <h2 class="cmn__title" id="mobile_text">
      Edit Challan
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
                  <div class="col-lg-6">
                     <div class="section__header section__center pb__60">
                        <h4 class="text-center" id="mobile_text">
                           Edit Challan
                        </h4>
                        <!-- <p>
                           Fill up the form and our team will get back to you within 24 hours
                        </p> -->
                     </div>
                  </div>
               </div>
               <div class="row justify-content-center">
                  <div class="col-xl-12 col-lg-12">
                     <div class="signup__boxes">
                        <form action="{{ route('challan.update', $challan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-4 justify-content-center">
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="company_id">Select Client</label>
                                     <select name="company_id" class="" id="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}"  {{ $company->id == $challan->company_id ? 'selected' : '' }}>{{ $company->industry_name }}</option>
                                        @endforeach
                                     </select>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="challan_number">Challan Number</label>
                                     <input type="text" name="challan_number" class="" value="{{ $challan->challan_number }}">
                                     @error('challan_number')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="date">Date</label>
                                     <input type="date" name="date" class="" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                     @error('date')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="purpose">Purpose</label>
                                     <select name="purpose_id" id="purpose" class="" required>
                                        <option value="">Select Purpose</option>
                                       @foreach(\App\Models\Purpose::all() as $purpose)
                                           <option value="{{ $purpose->id }}" {{ old('purpose', $challan->purpose_id) == $purpose->id ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                       @endforeach
                                     </select>
                                     
                                     @error('purpose')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               @if($challan->notes != '')
                                  <div class="col-lg-6" id="notes-box" style="display:block;">
                              @else
                                  <div class="col-lg-6" id="notes-box" style="display:none;">
                              @endif
                                  <div class="input__grp">
                                      <label for="notes">Notes</label>
                                      <textarea name="notes" id="notes" class="" rows="3">{{ $challan->notes }}</textarea>

                                      @error('notes')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>

                               <input type="hidden" id="industry_name" name="industry_name" value="{{ $challan->industry_name }}" class="" readonly>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="industry_name">Client Number</label>
                                     <input type="text" id="industry_number" name="industry_number" value="{{ $challan->industry_number }}" class="" readonly>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="industry_name">Client GST Number</label>
                                     <input type="text" id="industry_gstin" name="industry_gstin" value="{{ $challan->industry_gstin }}" class="" readonly>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="industry_name">Client Address</label>
                                     <input type="text" id="industry_address" name="industry_address" value="{{ $challan->industry_address }}" class="" readonly>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="vehicle_no">Vehicle Number</label>
                                     <input type="text" name="vehicle_no" class="" value="{{ $challan->vehicle_no }}">
                                     @error('vehicle_no')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="no_of_packages">No Of Packages</label>
                                     <input type="text" name="no_of_packages" class="" value="{{ $challan->no_of_packages }}">
                                     @error('no_of_packages')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <!-- <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="item_name">Item Name</label>
                                     <input type="text" name="item_name" class="">
                                     @error('item_name')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                      @enderror
                                  </div>
                                  </div>
                                  
                                  <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="hsn_code">HSN Code</label>
                                     <input type="text" name="hsn_code" class="">
                                     @error('hsn_code')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                      @enderror
                                  </div>
                                  </div>
                                  
                                  <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="price_per_kg">Price per Kilo/gram</label>
                                     <input type="number" step="0.01" id="price_per_kg" name="price_per_kg" class="" required>
                                  </div>
                                  </div>
                                  
                                  <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="total_qty">Total Quantity (KG)</label>
                                     <input type="number" step="0.001" name="total_qty" id="total_qty" class="" required>
                                     @error('total_qty')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                      @enderror
                                  </div>
                                  </div>
                                  <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="total_value">Total Value</label>
                                     <input type="number" step="0.01" name="total_value" id="total_value" class="" readonly>
                                     @error('total_value')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                      @enderror
                                  </div>
                                  </div> -->
                               <div class="col-12">
                                  <div class="d-flex justify-content-between align-items-center mb-2">
                                     <h5>Challan Items</h5>
                                     <button type="button" class="btn btn-sm btn-success" id="addItemBtn">+ Add Item</button>
                                  </div>
                                  <div id="itemsContainer">
                                     <!-- Initial Item Row -->
                                     @foreach($challan->items as $index => $item)
<div class="row g-3 item-row mb-2">

    <div class="col-lg-2">
        <div class="input__grp">
            <label>Item Name</label>
            <input type="text" name="items[{{ $index }}][item_name]" value="{{ $item->item_name }}" class="form-control" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="input__grp">
            <label>HSN Code</label>
            <input type="text" name="items[{{ $index }}][hsn_code]" value="{{ $item->hsn_code }}" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="input__grp">
            <label>Price per KG</label>
            <input type="number" step="0.01" name="items[{{ $index }}][price_per_kg]" value="{{ $item->price_per_kg }}" class="form-control price-per-kg" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="input__grp">
            <label>Qty (KG)</label>
            <input type="number" step="0.001" name="items[{{ $index }}][total_qty]" value="{{ $item->total_qty }}" class="form-control qty" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="input__grp">
            <label>Total Value</label>
            <input type="number" step="0.01" name="items[{{ $index }}][total_value]" value="{{ $item->total_value }}" class="form-control total-value" readonly>
        </div>
    </div>
    <div class="col-lg-1">
                                                    <div class="input__grp">
                                                        <label>Piece No.</label>
                                                        <input type="number" name="items[0][piece_no]" value="{{ $item->piece_no }}" class="form-control" min="0">
                                                    </div>
                                                </div>
    <div class="col-lg-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger removeItemBtn">X</button>
    </div>
</div>
@endforeach


                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="cgst">CGST (%)</label>
                                     <input type="number" sstep="0.01" name="cgst" id="cgst" value="{{ $challan->cgst }}" class="" required>
                                     @error('cgst')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="sgst">SGST (%)</label>
                                     <input type="number" step="0.01" name="sgst" id="sgst" value="{{ $challan->sgst }}" class="" required>
                                     @error('sgst')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="total_tax">Total Tax (₹)</label>
                                     <input type="number" step="0.01" name="total_tax" id="total_tax" value="{{ $challan->total_tax }}"  class="" readonly>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="input__grp">
                                     <label for="grand_total">Grand Total (₹)</label>
                                     <input type="number" step="0.01" name="grand_total" id="grand_total" value="{{ $challan->grand_total }}"  class="" readonly>
                                  </div>
                               </div>
                               <div class="col-lg-12">
                                  <div class="input__grp">
                                     <label for="description">Description</label>
                                     <textarea class="" rows="3" id="description" name="description" placeholder="Your message...">{{ $challan->description }} </textarea>
                                     @error('description')
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
                                     Update Challan
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
<script>
   $(document).ready(function() {
      $('#purpose').on('change', function() {
           var selectedPurpose = $(this).val();
   
           if (selectedPurpose !== '') {
               $('#notes-box').show(); // Show the notes box if a purpose is selected
           } else {
               $('#notes-box').hide(); // Hide if no purpose is selected
               $('#notes').val('');    // Optionally clear notes when hiding
           }
       });
   
      /*if (selectedPurpose !== '') {
          $('#notes-box').show();
          $('#notes').attr('required', true);
      } else {
          $('#notes-box').hide();
          $('#notes').removeAttr('required');
          $('#notes').val('');
      }*/
   
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
                
                <div class="col-lg-2">
                    <div class="input__grp">
                        <label>Item Name</label>
                        <input type="text" name="items[${itemIndex}][item_name]" class="form-control" required>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input__grp">
                        <label>HSN Code</label>
                        <input type="text" name="items[${itemIndex}][hsn_code]" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input__grp">
                        <label>Price per KG</label>
                        <input type="number" step="0.01" name="items[${itemIndex}][price_per_kg]" class="form-control price-per-kg" required>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input__grp">
                        <label>Qty (KG)</label>
                        <input type="number" step="0.001" name="items[${itemIndex}][total_qty]" class="form-control qty" required>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input__grp">
                        <label>Total Value</label>
                        <input type="number" step="0.01" name="items[${itemIndex}][total_value]" class="form-control total-value" readonly>
                    </div>
                </div>
         <div class="col-lg-1">
                       <div class="input__grp">
                           <label>Piece No.</label>
                           <input type="number" name="items[${itemIndex}][piece_no]" class="form-control" min="0">
                       </div>
                   </div>
                <div class="col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeItemBtn">X</button>
                </div>
            </div>`;

        container.append(newItemRow);
        itemIndex++;
    });

    // Remove item row and recalculate
    $('#itemsContainer').on('click', '.removeItemBtn', function () {
        $(this).closest('.item-row').remove();
        calculateAllTotals();
    });

    // Listen for changes in price or qty fields to recalculate row and totals
    $('#itemsContainer').on('input', '.price-per-kg, .qty', function () {
        const row = $(this).closest('.item-row');
        calculateItemTotal(row);
        calculateAllTotals();
    });

    // Listen for changes in GST fields
    $('#cgst, #sgst').on('input', function () {
        calculateAllTotals();
    });

    // Initial recalculation on page load for preloaded items
    recalculateExistingRows();
});

   
</script>
@endpush
@endsection