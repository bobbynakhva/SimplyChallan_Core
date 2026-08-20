@extends('layout-inward.app')
@section('title', 'Edit Inward Challan')

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
    
    .form-control[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
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
        border-radius: 50%;
        width: 38px;
        height: 38px;
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
                        <a href="{{ route('inward.challan.create') }}" class="sidebar-link active">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>New Inward Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid"></i>
                            <span>Manage Inward Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.challan.reports') }}" class="sidebar-link">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Inward Reports</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.purposes.index') }}" class="sidebar-link">
                            <i class="bi bi-tag"></i>
                            <span>Manage Purposes</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('companies.create') }}" class="sidebar-link">
                            <i class="bi bi-building"></i>
                            <span>Create Client Company</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="common__body">
                <div class="container">
                    <form action="{{ route('inward.challan.update', $challan->id) }}" method="POST" id="mainChallanForm">
                        @csrf
                        @method('PUT')
                        <div class="challan-card">
                            
                            <!-- Header -->
                            <div class="page-header">
                                <h4 class="page-title">Edit Inward Challan</h4>
                                <div class="text-muted small">Update incoming material details</div>
                            </div>

                            <!-- ROW 1: Basic Info -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-4 form-group">
                                    <label>Select Client <span class="text-danger">*</span></label>
                                    <select name="company_id" id="company_id" class="form-select" required>
                                        <option value="">Select Company...</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $challan->company_id ? 'selected' : '' }}>{{ $company->industry_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Challan Number</label>
                                    <input type="text" name="challan_number" value="{{ $challan->challan_number }}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', optional($challan->date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <!-- ROW 2: Purpose & Reference -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6 form-group">
                                    <label>Main Challan Number</label>
                                    <input type="text" name="main_challan_number" value="{{ $challan->main_challan_number }}" placeholder="Optional reference number" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Purpose <span class="text-danger">*</span></label>
                                    <select name="purpose_id" id="purpose" class="form-select" required>
                                        <option value="">Select Purpose...</option>
                                        @foreach($purposes as $purpose)
                                            <option value="{{ $purpose->id }}" {{ $challan->purpose_id == $purpose->id ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- ROW 3: Client Details (Readonly) -->
                            <div class="row g-4 mb-4">
                                <input type="hidden" id="industry_name" name="industry_name" value="{{ $challan->industry_name }}">
                                <input type="hidden" id="industry_address" name="industry_address" value="{{ $challan->industry_address }}">
                                
                                <div class="col-md-6 form-group">
                                    <label>Client Number</label>
                                    <input type="text" id="industry_number" name="industry_number" value="{{ $challan->industry_number }}" class="form-control" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Client GSTIN</label>
                                    <input type="text" id="industry_gstin" name="industry_gstin" value="{{ $challan->industry_gstin }}" class="form-control" readonly>
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
                                    @foreach($challan->inwarditems as $index => $item)
                                    <div class="row g-3 item-row mb-3 align-items-end">
                                        <div class="col-md-4 form-group">
                                            <label>Item Name</label>
                                            <input type="text" name="inwarditems[{{ $index }}][item_name]" value="{{ $item->item_name }}" class="form-control" placeholder="Item Name" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Quantity (Kg)</label>
                                            <input type="number" step="0.001" name="inwarditems[{{ $index }}][qty]" value="{{ $item->qty }}" class="form-control qty" placeholder="0.000" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Pieces</label>
                                            <input type="number" name="inwarditems[{{ $index }}][piece_no]" value="{{ $item->piece_no }}" class="form-control piece_no" placeholder="0">
                                        </div>
                                        <div class="col-md-2 text-end" style="padding-bottom: 5px;">
                                            <button type="button" class="btn-remove removeItemBtn"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="row mt-4 justify-content-end">
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded border">
                                        <div class="mb-3">
                                             <label class="fw-bold text-muted small">Total Quantity (Kg)</label>
                                             <input type="number" name="total_qty" id="total_qty" value="{{ $challan->total_qty }}" step="0.01" class="form-control fw-bold text-dark" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER ACTION -->
                            <div class="text-center mt-5 mb-3 d-flex flex-column align-items-center">
                                <button type="submit" class="btn-gold">
                                    Update Inward Challan <span class="badge bg-white text-dark ms-2 opacity-75" style="font-size: 0.7rem; vertical-align: middle;">Ctrl + S</span> <i class="bi bi-check2-circle ms-2"></i>
                                </button>

                                <!-- Keyboard Shortcut Helper -->
                                <div class="shortcut-helper mt-3 text-muted text-center" style="font-size: 0.8rem; background: #f8fafc; padding: 8px 18px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                     <i class="bi bi-keyboard me-1 text-warning"></i> 
                                     <span class="me-3"><strong>Alt + C</strong>: Select Client Search</span>
                                     <span class="me-3"><strong>Enter</strong>: Next Field / Add Row</span>
                                     <span class="me-3"><strong>Ctrl + S</strong>: Update Challan</span>
                                     <span class="me-3"><strong>Alt + A</strong>: Add New Row</span>
                                     <span><strong>Alt + D</strong>: Remove Row</span>
                                </div>
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
            placeholder: "Select Company...",
            allowClear: true,
            width: '100%'
        });

        $('#purpose').niceSelect('destroy').select2({
            placeholder: "Select Purpose...",
            allowClear: true,
            width: '100%'
        });

        // INSTANT SEARCH FOCUS FOR SELECT2 DROPDOWNS
        $(document).on('select2:open', function() {
            setTimeout(function() {
                let searchInput = document.querySelector('.select2-container--open .select2-search__field');
                if (searchInput) {
                    searchInput.focus();
                }
            }, 10);
        });

        // Auto-focus first item row field on page load
        setTimeout(function() {
            $('#itemsContainer .item-row').first().find('input').first().focus();
        }, 300);
        
        // Client Details Fetcher
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

        // Items Logic
        let itemIndex = {{ $challan->inwarditems->count() }}; // Start from existing
        if(itemIndex === 0) itemIndex = 1;

        function addNewItemRow() {
            const newItemRow = `
                <div class="row g-3 item-row mb-3 align-items-end">
                    <div class="col-md-4 form-group">
                        <label>Item Name</label>
                        <input type="text" name="inwarditems[${itemIndex}][item_name]" class="form-control" placeholder="Item Name" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Quantity (Kg)</label>
                        <input type="number" step="0.001" name="inwarditems[${itemIndex}][qty]" class="form-control qty" placeholder="0.000" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Pieces</label>
                        <input type="number" name="inwarditems[${itemIndex}][piece_no]" class="form-control piece_no" placeholder="0">
                    </div>
                    <div class="col-md-2 text-end" style="padding-bottom: 5px;">
                        <button type="button" class="btn-remove removeItemBtn"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>`;
            $('#itemsContainer').append(newItemRow);
            itemIndex++;
        }

        $('#addItemBtn').on('click', function () {
            addNewItemRow();
        });

        $('#itemsContainer').on('click', '.removeItemBtn', function () {
            if ($('#itemsContainer .item-row').length > 1) {
                $(this).closest('.item-row').remove();
                calculateTotal();
            } else {
                alert("At least one item is required.");
            }
        });

        // Calculate Total
        function calculateTotal() {
            let totalQty = 0;
            $('.qty').each(function () {
                let val = parseFloat($(this).val()) || 0;
                totalQty += val;
            });
            $('#total_qty').val(totalQty.toFixed(2));
        }

        $('#itemsContainer').on('input', '.qty', function () {
            calculateTotal();
        });
        
        // KEYBOARD SHORTCUTS & SMART ENTER NAVIGATION
        // A. Enter Key Navigation within Item Rows
        $('#itemsContainer').on('keydown', 'input', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                let currentRow = $(this).closest('.item-row');
                let inputs = currentRow.find('input:not([readonly])');
                let index = inputs.index(this);

                if (index < inputs.length - 1) {
                    // Move focus to next field in current row
                    inputs.eq(index + 1).focus().select();
                } else {
                    // On last input of row, automatically add a new row & focus its item name
                    addNewItemRow();
                    let newRow = $('#itemsContainer .item-row').last();
                    newRow.find('input').first().focus();
                }
            }
        });

        // B. Global Hotkeys (Ctrl+S: Save, Alt+C: Search Client, Alt+A: Add Row, Alt+D: Remove Row)
        $(document).on('keydown', function(e) {
            // Alt+C => Open Select Client & Focus Search Box Instantly
            if (e.altKey && (e.key === 'c' || e.key === 'C')) {
                e.preventDefault();
                $('#company_id').select2('open');
            }
            // Ctrl+S or Alt+S => Save Form
            if ((e.ctrlKey || e.altKey) && (e.key === 's' || e.key === 'S')) {
                e.preventDefault();
                $('#company_id').closest('form').submit();
            }
            // Alt+A => Add New Item Row
            if (e.altKey && (e.key === 'a' || e.key === 'A')) {
                e.preventDefault();
                addNewItemRow();
                let newRow = $('#itemsContainer .item-row').last();
                newRow.find('input').first().focus();
            }
            // Alt+D => Remove Currently Focused Item Row
            if (e.altKey && (e.key === 'd' || e.key === 'D')) {
                e.preventDefault();
                let focused = $(document.activeElement);
                if (focused.closest('.item-row').length > 0) {
                    focused.closest('.item-row').find('.removeItemBtn').click();
                }
            }
        });

        // Initial calc
        calculateTotal();
    });
</script>
@endpush