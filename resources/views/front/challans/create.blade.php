@extends('layout.app')

@section('title', 'Create Challan')

@push('styles')
<style>
    /* === PROFESSIONAL THEME: GOLD & WHITE === */
    body, .page-wrapper {
        background-color: #f7f9fc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #1e293b;
    }

    /* GLOBAL FOCUS RESET */
    *:focus {
        outline: none !important;
        box-shadow: none !important; 
    }

    /* === SIDEBAR (Standardized) === */
    ul.common__sidebar__wrapper {
        background-color: #ffffff !important;
        border-radius: 12px;
        padding: 20px 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        min-height: calc(100vh - 100px);
        display: flex;
        flex-direction: column;
        gap: 8px;
        border: 1px solid #f1f5f9;
        margin-top: 50px;
    }
    
    .side__sticky {
        position: sticky;
        top: 110px !important;
        z-index: 99;
    }

    .common__sideitems {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .sidebar-link:hover {
        background-color: #f8fafc;
        color: #334155;
        transform: translateX(4px);
    }

    .sidebar-link.active {
        background-color: #f59e0b !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.25);
        font-weight: 600;
    }
    
    .sidebar-link i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    /* === FORM CARD === */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
    }

    /* Form Elements - Pill Style */
    .form-group label {
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control, .form-select {
        border-radius: 50px !important; /* Pill Shape */
        border: 1px solid #e2e8f0;
        padding: 12px 20px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s;
        background-color: #f8fafc;
        height: auto;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    /* Readonly inputs */
    .form-control[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* Buttons */
    .btn-gold {
        background-color: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.25);
    }
    .btn-gold:hover {
        background-color: #d97706;
        color: white;
        transform: translateY(-2px);
    }

    .btn-add-item {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fcd34d;
        border-radius: 50px;
        font-weight: 600;
        padding: 8px 20px;
        font-size: 0.9rem;
    }
    .btn-add-item:hover {
        background-color: #f59e0b;
        color: white;
    }

    .btn-remove {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fee2e2;
        color: #ef4444;
        border: none;
        transition: all 0.2s;
    }
    .btn-remove:hover {
        background: #ef4444;
        color: white;
    }

    /* Items Section */
    .items-container {
        border-top: 1px solid #e2e8f0;
        padding-top: 30px;
        margin-top: 30px;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 20px;
    }
    
    /* Grand Total Box */
    .total-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
    }
    /* Select2 Pill Styling */
    .select2-container--default .select2-selection--single {
        border: 1px solid #e2e8f0 !important;
        border-radius: 50px !important; /* Match Pill Style */
        height: 48px !important;
        padding-top: 10px !important;
        transition: all 0.2s ease-in-out !important;
        background-color: #f8fafc !important;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #f59e0b !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-weight: 500 !important;
        padding-left: 20px !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        margin-top: 5px !important;
    }
    .select2-search__field {
        border-radius: 50px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 8px 16px !important;
    }
    .select2-search__field:focus {
        border-color: #f59e0b !important;
        outline: none !important;
    }
    .select2-results__option--highlighted[aria-selected] {
        background-color: #f59e0b !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="common__section page-wrapper">
    <div class="container-fluid">
        <div class="divided__common__body">
            
            <!-- SIDEBAR -->
            <div class="side__sticky">
                <ul class="common__sidebar__wrapper">
                    <li class="common__sideitems">
                        <a href="{{ route('challan.create') }}" class="sidebar-link {{ request()->routeIs('challan.create') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>New Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid"></i>
                            <span>Manage Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('challan.reports') }}" class="sidebar-link {{ request()->routeIs('challan.reports') ? 'active' : '' }}">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('purposes.index') }}" class="sidebar-link {{ request()->routeIs('purposes.index') ? 'active' : '' }}">
                            <i class="bi bi-tag"></i>
                            <span>New Purpose</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="common__body">
                <div class="container">
                    <form action="{{ route('challan.store') }}" method="POST">
                        @csrf
                        <div class="challan-card">
                            
                            <!-- Header -->
                            <div class="page-header">
                                <h4 class="page-title">New Outward Challan</h4>
                                <div class="text-muted small">Fill in the details below</div>
                            </div>

                            <!-- ROW 1: Basic Info -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-4 form-group">
                                    <label>Select Client <span class="text-danger">*</span></label>
                                    <select name="company_id" id="company_id" required class="form-select">
                                        <option value="">Choose Company...</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $selectedclient->id ? 'selected' : '' }}>{{ $company->industry_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Challan Number</label>
                                    <input type="text" name="challan_number" class="form-control" value="{{ old('challan_number', $challan_no) }}" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- ROW 2: Purpose & Notes -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6 form-group">
                                    <label>Purpose <span class="text-danger">*</span></label>
                                    <select name="purpose_id" id="purpose" class="form-select" required>
                                        <option value="">Select Purpose...</option>
                                        @foreach($purposes as $purpose)
                                            <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group" id="notes-box" style="display:none;">
                                    <label>Notes</label>
                                    <input type="text" name="notes" id="notes" class="form-control" placeholder="Add any notes here...">
                                </div>
                            </div>

                            <!-- ROW 3: Client Details (Readonly) -->
                            <div class="row g-4 mb-4">
                                <input type="hidden" id="industry_name" name="industry_name" value="{{ $selectedclient->industry_name ?? null }}">
                                <div class="col-md-4 form-group">
                                    <label>Client Number</label>
                                    <input type="text" id="industry_number" name="industry_number" value="{{ $selectedclient->industry_number ?? null }}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Client GSTIN</label>
                                    <input type="text" id="industry_gstin" name="industry_gstin" value="{{ $selectedclient->industry_gstin ?? null }}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Client Address</label>
                                    <input type="text" id="industry_address" name="industry_address" value="{{ $selectedclient->industry_address ?? null }}" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- ROW 4: Logistics -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6 form-group">
                                    <label>Vehicle Number</label>
                                    <input type="text" name="vehicle_no" class="form-control" placeholder="e.g. GJ-10-XX-1234">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>No. of Packages</label>
                                    <input type="text" name="no_of_packages" class="form-control" placeholder="0">
                                </div>
                            </div>

                            <!-- ITEMS SECTION -->
                            <div class="items-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="section-title">Challan Items</h5>
                                    <button type="button" class="btn-add-item" id="addItemBtn">
                                        <i class="bi bi-plus-lg"></i> Add Item
                                    </button>
                                </div>

                                <div id="itemsContainer">
                                    <!-- Initial Item Row -->
                                    <div class="row g-3 item-row mb-3 align-items-end">
                                        <div class="col-md-3 form-group">
                                            <label>Item Name</label>
                                            <input type="text" name="items[0][item_name]" class="form-control" placeholder="Item Name" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Piece</label>
                                            <input type="number" name="items[0][piece_no]" class="form-control" placeholder="0">
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label>HSN</label>
                                            <input type="text" name="items[0][hsn_code]" class="form-control hsn-code" placeholder="HSN">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Price/Kg</label>
                                            <input type="number" step="0.01" name="items[0][price_per_kg]" class="form-control price-per-kg" placeholder="0.00" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Qty (Kg)</label>
                                            <input type="number" step="0.001" name="items[0][total_qty]" class="form-control qty" placeholder="0.000" required>
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label>Total</label>
                                            <input type="number" step="0.01" name="items[0][total_value]" class="form-control total-value" readonly>
                                        </div>
                                        <div class="col-md-1 text-end" style="padding-bottom: 5px;">
                                            <button type="button" class="btn-remove removeItemBtn"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAX & TOTALS -->
                            <div class="row mt-4">
                                <div class="col-md-6 form-group">
                                    <label>Description / Remarks</label>
                                    <textarea class="form-control" rows="4" id="description" name="description" style="border-radius: 20px;" placeholder="Optional remarks..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="total-box">
                                        <div class="row g-3 mb-3">
                                            <div class="col-6 form-group">
                                                <label>CGST (%)</label>
                                                <input type="number" step="0.01" name="cgst" id="cgst" value="9" class="form-control">
                                            </div>
                                            <div class="col-6 form-group">
                                                <label>SGST (%)</label>
                                                <input type="number" step="0.01" name="sgst" id="sgst" value="9" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-6 form-group">
                                                <label>Tax Amount</label>
                                                <input type="number" step="0.01" name="total_tax" id="total_tax" class="form-control" readonly>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label class="text-dark fw-bold">Grand Total (₹)</label>
                                                <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control fw-bold fs-5 text-dark" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER ACTION -->
                            <div class="text-center mt-5 mb-3">
                                <button type="submit" class="btn-gold">
                                    Save Challan <i class="bi bi-check2-circle ms-2"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
      
      // Initialize Select2 (Destroy nice-select if initialized globally)
      $('#company_id').niceSelect('destroy').select2({
          placeholder: "Choose Company...",
          allowClear: true,
          width: '100%'
      });

      $('#purpose').niceSelect('destroy').select2({
          placeholder: "Select Purpose...",
          allowClear: true,
          width: '100%'
      });
      
      // Purpose & Notes Logic
      $('#purpose').on('change', function() {
           var selectedPurpose = $(this).val();
           if (selectedPurpose !== '') {
               $('#notes-box').slideDown();
           } else {
               $('#notes-box').slideUp();
               $('#notes').val('');
           }
       });
   
       // Company Details Fetcher
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
                       $('#industry_address').val(response.industry_address);
                   },
                   error: function() {
                       alert('Company details not found!');
                   }
               });
           } else {
               $('#industry_name, #industry_number, #industry_gstin, #industry_address').val('');
           }
       });

       // Item Calculations
       let itemIndex = 1;
   
       function calculateItemTotal(row) {
           let price = parseFloat(row.find('.price-per-kg').val()) || 0;
           let qty = parseFloat(row.find('.qty').val()) || 0;
           let total = price * qty;
           row.find('.total-value').val(total.toFixed(2));
       }
   
       function calculateAllTotals() {
           let totalValueSum = 0;
           $('.total-value').each(function () {
               let val = parseFloat($(this).val()) || 0;
               totalValueSum += val;
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
   
       // Add Item
       $('#addItemBtn').on('click', function () {
           const container = $('#itemsContainer');
           
           // Get values from the last row to copy
           let lastRow = container.find('.item-row').last();
           let lastHsn = lastRow.find('input[name*="[hsn_code]"]').val() || '';
           let lastPrice = lastRow.find('input[name*="[price_per_kg]"]').val() || '';

           const newItemRow = `
                <div class="row g-3 item-row mb-3 align-items-end">
                    <div class="col-md-3 form-group">
                         <label>Item Name</label>
                         <input type="text" name="items[${itemIndex}][item_name]" class="form-control" placeholder="Item Name" required>
                    </div>
                    <div class="col-md-2 form-group">
                         <label>Piece</label>
                         <input type="number" name="items[${itemIndex}][piece_no]" class="form-control" placeholder="0">
                    </div>
                    <div class="col-md-1 form-group">
                         <label>HSN</label>
                         <input type="text" name="items[${itemIndex}][hsn_code]" class="form-control hsn-code" placeholder="HSN" value="${lastHsn}">
                    </div>
                    <div class="col-md-2 form-group">
                         <label>Price/Kg</label>
                         <input type="number" step="0.01" name="items[${itemIndex}][price_per_kg]" class="form-control price-per-kg" placeholder="0.00" value="${lastPrice}" required>
                    </div>
                    <div class="col-md-2 form-group">
                         <label>Qty (Kg)</label>
                         <input type="number" step="0.001" name="items[${itemIndex}][total_qty]" class="form-control qty" placeholder="0.000" required>
                    </div>
                    <div class="col-md-1 form-group">
                         <label>Total</label>
                         <input type="number" step="0.01" name="items[${itemIndex}][total_value]" class="form-control total-value" readonly>
                    </div>
                    <div class="col-md-1 text-end" style="padding-bottom: 5px;">
                        <button type="button" class="btn-remove removeItemBtn"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>`;
           
           container.append(newItemRow);
           
           // Trigger calculation for the new row if price was copied (and qty is empty, total remains 0)
           // But actually we need qty to calculate total. 
           // Just to be safe, let's init the new row's calculation state
           let newRow = container.find('.item-row').last();
           calculateItemTotal(newRow);

           itemIndex++;
       });
   
       // Remove Item
       $('#itemsContainer').on('click', '.removeItemBtn', function () {
           if($('#itemsContainer .item-row').length > 1) {
               $(this).closest('.item-row').remove();
               calculateAllTotals();
           } else {
               alert("At least one item is required.");
           }
       });
   
       // Input Listeners
       $('#itemsContainer').on('input', '.price-per-kg, .qty', function () {
           const row = $(this).closest('.item-row');
           calculateItemTotal(row);
           calculateAllTotals();
       });

       // LocalStorage Persistence for Row 1
       // Save to LocalStorage on input change
       $('#itemsContainer').on('input', '.hsn-code, .price-per-kg', function() {
           // We only want to save the "default" values, maybe from the first row?
           // Let's save the *last modified* value as the default for next session
           let val = $(this).val();
           if ($(this).hasClass('hsn-code')) {
               localStorage.setItem('default_hsn', val);
           } else if ($(this).hasClass('price-per-kg')) {
               localStorage.setItem('default_price', val);
           }
       });

       // Load from LocalStorage on Init (only if inputs are empty)
       let savedHsn = localStorage.getItem('default_hsn');
       let savedPrice = localStorage.getItem('default_price');
       
       if (savedHsn) {
           let firstHsnInput = $('input[name="items[0][hsn_code]"]');
           if (firstHsnInput.val() === '') {
               firstHsnInput.val(savedHsn);
           }
       }
       if (savedPrice) {
           let firstPriceInput = $('input[name="items[0][price_per_kg]"]');
           if (firstPriceInput.val() === '') {
               firstPriceInput.val(savedPrice);
               // Trigger calc? No qty yet so fine.
           }
       }
   
       $('#cgst, #sgst').on('input', function () {
           calculateAllTotals();
       });
   
       calculateAllTotals();
   });
</script>
@endpush