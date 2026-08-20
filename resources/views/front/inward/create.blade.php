@extends('layout-inward.app')

@section('title', 'Create Challan')

@push('styles')
<style>
    /* 
     * PROFESSIONAL THEME OVERRIDE
     * Specificity boosted to ensure "Changed" look
     */

    body, .page-wrapper {
        background-color: #f7f9fc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #1e293b;
    }

    /* Main Card - Minimalist White */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); /* Subtle, refined shadow */
        padding: 40px;
        max-width: 1200px;
        margin: 30px auto;
        border: 1px solid #e2e8f0;
    }

    /* Labels - Uppercase and Gold/Dark Header style */
    .field-pill label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin-bottom: 8px;
        margin-left: 4px;
    }

    /* Inputs - Professional Standard */
    .pill-input .form-control {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px !important; /* Slightly less rounded than full pill for pro look */
        padding: 10px 16px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #0f172a;
        width: 100%;
        height: 44px;
        transition: all 0.2s ease-in-out;
    }
    .pill-input .form-control:focus {
        border-color: #f59e0b; /* Gold accent focus */
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15); /* Gold glow */
        outline: none;
    }
    .pill-input .form-control[readonly] {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #64748b;
    }

    /* Custom Grids */
    .challan-header-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    .challan-items-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .challan-items-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.01em;
    }
    
    /* Items Table-Like Grid */
    .challan-items-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 16px;
        align-items: start;
        padding: 16px;
        border: 1px solid transparent;
        border-radius: 8px;
    }
    .challan-items-grid:hover {
        background-color: #f8fafc;
        border-color: #f1f5f9;
    }

    /* Buttons - The Gold Standard */
    .btn-add-item {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 20px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-add-item:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .btn-save-challan {
        background-color: #f59e0b; /* Gold Action Button */
        color: #ffffff;
        border: none;
        padding: 12px 40px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
        transition: all 0.2s;
        text-transform: uppercase;
    }
    .btn-save-challan:hover {
        background-color: #d97706; /* Darker Gold */
        box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.4);
        transform: translateY(-1px);
    }

    .btn-remove-item {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-remove-item:hover {
        background-color: #fee2e2;
        border-color: #fecaca;
    }

    /* Total Badge */
    .total-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .total-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: #f59e0b; /* Gold text for total */
    }

    /* Footer Layout */
    .challan-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 24px;
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    /* Remove Arrows from Number Input */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    /* Select2 Premium Styling */
    .select2-container--default .select2-selection--single {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        height: 44px !important;
        padding-top: 8px !important;
        transition: all 0.2s ease-in-out !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #0f172a !important;
        font-weight: 500 !important;
        padding-left: 16px !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
    }
    .select2-search__field {
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 8px 12px !important;
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
            @include('layout-inward.sidebar')
            <div class="common__body">
                
                <form action="{{ route('inward.challan.store') }}" method="POST" id="mainChallanForm">
                @csrf

                <div class="challan-card">

                    <!-- TOP SECTION: HEADER GRID -->
                    <div class="challan-header-grid">
                        <!-- 1 -->
                        <div class="field-pill">
                            <label>Select Client</label>
                            <div class="pill-input">
                                <select name="company_id" id="company_id" class="form-control" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $selectedclient->id ? 'selected' : '' }}>
                                            {{ $company->industry_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- 2 -->
                        <div class="field-pill">
                            <label>Client Number</label>
                            <div class="pill-input">
                                <input type="text" id="industry_number" name="industry_number" value="{{ $selectedclient->industry_number ?? '' }}" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- 3 -->
                        <div class="field-pill">
                            <label>Client GST Number</label>
                            <div class="pill-input">
                                <input type="text" id="industry_gstin" name="industry_gstin" value="{{ $selectedclient->industry_gstin ?? '' }}" class="form-control" readonly>
                            </div>
                        </div>

                        <input type="hidden" id="industry_name" name="industry_name" value="{{ $selectedclient->industry_name ?? '' }}">

                        <!-- 4 -->
                        <div class="field-pill">
                            <label>Date</label>
                            <div class="pill-input">
                                <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="form-control">
                            </div>
                            @error('date') <span class="text-danger small ms-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- 5 -->
                        <div class="field-pill">
                            <label>Purpose</label>
                            <div class="pill-input">
                                <select name="purpose_id" id="purpose" class="form-control" required>
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('purpose_id') <span class="text-danger small ms-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- 6 -->
                        <div class="field-pill">
                            <label>Main Challan Number</label>
                            <div class="pill-input">
                                <input type="text" name="main_challan_number" class="form-control">
                            </div>
                            @error('main_challan_number') <span class="text-danger small ms-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- MID SECTION: ITEMS HEADER -->
                    <div class="challan-items-header">
                        <div class="challan-items-title">
                            Challan Items
                        </div>
                        <button type="button" class="btn-add-item" id="addItemBtn">
                            + Add Item
                        </button>
                    </div>

                    <!-- ITEMS CONTAINER -->
                    <div id="itemsContainer">
                        <!-- ITEM ROW -->
                        <div class="challan-items-grid item-row">
                            <div class="field-pill">
                                <label>Item Name</label>
                                <div class="pill-input">
                                    <input type="text" name="inwarditems[0][item_name]" class="form-control" required>
                                </div>
                            </div>

                            <div class="field-pill">
                                <label>Qty (kgs)</label>
                                <div class="pill-input">
                                    <input type="number" name="inwarditems[0][qty]" step="0.00001" class="form-control qty" required>
                                </div>
                            </div>

                            <div class="field-pill">
                                <label>Piece No.</label>
                                <div class="pill-input">
                                    <input type="number" name="inwarditems[0][piece_no]" class="form-control piece_no">
                                </div>
                            </div>

                            <div class="field-pill field-remove">
                                <label>&nbsp;</label> <!-- Spacer for alignment -->
                                <button type="button" class="btn-remove-item removeItemBtn" title="Remove">
                                    <i class="bi bi-x-lg"></i> X
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER SECTION -->
                    <div class="challan-footer flex-column align-items-center">
                        <div class="d-flex justify-content-center align-items-center gap-4 w-100">
                            <button type="submit" class="btn-save-challan">Save Challan <span class="badge bg-white text-dark ms-2 opacity-75" style="font-size: 0.7rem; vertical-align: middle;">Ctrl + S</span></button>

                            <div class="total-pill">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Qty</span>
                                <div class="total-value" id="total_qty_display">0.00</div>
                                <input type="hidden" name="total_qty" id="total_qty" value="0.00">
                            </div>
                        </div>

                        <!-- Keyboard Shortcut Helper -->
                        <div class="shortcut-helper mt-3 text-muted text-center" style="font-size: 0.8rem; background: #f8fafc; padding: 8px 18px; border-radius: 20px; border: 1px solid #e2e8f0;">
                            <i class="bi bi-keyboard me-1 text-warning"></i> 
                            <span class="me-3"><strong>Alt + C</strong>: Select Client Search</span>
                            <span class="me-3"><strong>Enter</strong>: Next Field / Add Row</span>
                            <span class="me-3"><strong>Ctrl + S</strong>: Save Challan</span>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Initialize Select2 (Destroy nice-select if initialized globally)
    $('#company_id').niceSelect('destroy').select2({
        placeholder: "Select Company",
        allowClear: true,
        width: '100%'
    });

    $('#purpose').niceSelect('destroy').select2({
        placeholder: "Select Purpose",
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

    // Auto-focus & open Select Client on page load
    setTimeout(function() {
        $('#company_id').select2('open');
    }, 300);

    // Sequential Navigation: Select Client -> Date -> Purpose -> Main Challan No -> Items
    $('#company_id').on('select2:select', function() {
        setTimeout(function() {
            $('input[name="date"]').focus();
        }, 100);
    });

    $('input[name="date"]').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#purpose').select2('open');
        }
    });

    $('#purpose').on('select2:select', function() {
        setTimeout(function() {
            $('input[name="main_challan_number"]').focus();
        }, 100);
    });

    $('input[name="main_challan_number"]').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#itemsContainer .item-row').first().find('input').first().focus().select();
        }
    });

    // 1. Client Details
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
                    console.error('Company details not found');
                }
            });
        }
    });

    // 2. Calculations
    function calculateTotals() {
        let totalQty = 0;
        $('.qty').each(function () {
            let val = parseFloat($(this).val()) || 0;
            totalQty += val;
        });
        $('#total_qty').val(totalQty.toFixed(2));
        $('#total_qty_display').text(totalQty.toFixed(2));
    }

    $('#itemsContainer').on('input', '.qty', function () {
        calculateTotals();
    });

    // 3. Add Item
    let itemIndex = 1;
    function addNewItemRow() {
        let itemHtml = `
            <div class="challan-items-grid item-row">
                <div class="field-pill">
                    <div class="pill-input">
                        <input type="text" name="inwarditems[${itemIndex}][item_name]" class="form-control" placeholder="Item Name" required>
                    </div>
                </div>

                <div class="field-pill">
                    <div class="pill-input">
                        <input type="number" name="inwarditems[${itemIndex}][qty]" step="0.00001" class="form-control qty" placeholder="0.00" required>
                    </div>
                </div>

                <div class="field-pill">
                    <div class="pill-input">
                        <input type="number" name="inwarditems[${itemIndex}][piece_no]" class="form-control piece_no" placeholder="0">
                    </div>
                </div>

                <div class="field-pill field-remove">
                     <button type="button" class="btn-remove-item removeItemBtn" title="Remove">
                        <i class="bi bi-x-lg"></i> X
                    </button>
                </div>
            </div>`;
        
        $('#itemsContainer').append(itemHtml);
        itemIndex++;
    }

    $('#addItemBtn').click(function() {
        addNewItemRow();
    });

    // 4. Remove Item
    $(document).on('click', '.removeItemBtn', function() {
        let rows = $('#itemsContainer .item-row');
        if (rows.length > 1) {
            $(this).closest('.item-row').remove();
            calculateTotals();
        } else {
            let row = $(this).closest('.item-row');
            row.find('input').val('');
            calculateTotals();
        }
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

});
</script>
@endpush
