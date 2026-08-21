@extends('layout.app')

@section('title', 'Manage Challan Items')

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

    /* === FLEX LAYOUT & FULL WIDTH CONTENT === */
    .divided__common__body {
        display: flex;
        width: 100%;
    }
    .divided__common__body .side__sticky {
        width: 220px;
        position: fixed;
        top: 0px;
        z-index: 99;
    }
    .common__body {
        margin-left: 240px !important;
        width: calc(100% - 240px) !important;
        max-width: calc(100% - 240px) !important;
        flex: 1;
        min-width: 0;
        padding: 110px 30px 40px 0 !important;
        box-sizing: border-box !important;
    }
    @media (max-width: 1199px) {
        .common__body {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 20px 15px !important;
        }
    }

    /* === MAIN CARD === */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
        width: 100% !important;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto !important;
        overflow-y: visible !important;
        -webkit-overflow-scrolling: touch;
        width: 100% !important;
    }
    #challanTable {
        width: 100% !important;
        border-collapse: collapse;
        border-spacing: 0;
    }
    #challanTable thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 8px;
        border-bottom: 2px solid #e2e8f0;
        border-top: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    #challanTable tbody td {
        background-color: #ffffff;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 500;
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
        white-space: nowrap;
    }
    #challanTable thead th:last-child,
    #challanTable tbody td:last-child {
        border-right: none;
    }
    #challanTable tbody tr:hover td {
        background-color: #fdfdfd;
    }

    /* Badges */
    .badge-completed {
        background-color: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid #bbf7d0;
    }
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid #fde68a;
    }

    /* Return Button */
    .btn-return {
        background-color: #f59e0b;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-return:hover {
        background-color: #d97706;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
    }

    /* Modal Styling & Layout Fixes */
    .white-popup {
        position: relative;
        background: #FFF;
        padding: 35px 40px;
        width: 100% !important;
        max-width: 700px !important;
        margin: 20px auto;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        display: block !important;
    }
    .white-popup form,
    .return-form {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
    }
    .modal-error-alert {
        width: 100% !important;
        flex-shrink: 0;
        margin-bottom: 20px !important;
    }
    .form--label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }
    .form--control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        width: 100%;
        color: #1e293b;
    }
    .form--control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    .modal-btn {
        background-color: #f59e0b;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .modal-btn:hover {
        background-color: #d97706;
        transform: translateY(-1px);
    }

    /* Modal Badges */
    .badge-sent-modal {
        background-color: #eef2ff;
        color: #3730a3;
        border: 1.5px solid #c7d2fe;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
    }
    .badge-remaining-modal {
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
    }
    .badge-remaining-modal.remaining-active {
        background-color: #fffbeb;
        color: #b45309;
        border: 1.5px solid #fde68a;
    }
    .badge-remaining-modal.remaining-zero {
        background-color: #ecfdf5;
        color: #047857;
        border: 1.5px solid #a7f3d0;
    }
    
    /* DataTables Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f59e0b !important;
        border-color: #f59e0b !important;
        color: white !important;
        border-radius: 6px;
        font-weight: 700;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fef3c7 !important;
        border-color: #fcd34d !important;
        color: #92400e !important;
    }
    .dataTables_length select:focus, 
    .dataTables_filter input:focus {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15) !important;
    }

    .form--control.is-invalid {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }
</style>
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
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('challan.items') ? 'active' : '' }}">
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
            <div class="common__body flex-grow-1 min-vw-0">
                <div class="challan-card w-100">
                        
                        <!-- Header -->
                        <div class="page-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="page-title">Manage Challan Items</h4>
                                <span class="text-muted small">Detail view of challan items and returns</span>
                            </div>
                            <div>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3 fw-semibold">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Challans
                                </a>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table align-middle" id="challanTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Total Sent (kg)</th>
                                        <th>Returned (kg)</th>
                                        <th>Waste/Scrap (kg)</th>
                                        <th>Unrecoverable (kg)</th>
                                        <th>Total Pcs</th>
                                        <th>Returned Pcs</th>
                                        <th>Remaining Pcs</th>
                                        <th>Last Despatch</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($challan->items as $key => $item)
                                        @php
                                            $totalReturned = max(0, $item->returns->sum('quantity_returned'));
                                            $wasteScrapReturned = max(0, $item->returns->sum('waste_scrap_returned'));
                                            $wasteNotRecoverable = max(0, $item->returns->sum('waste_not_recoverable'));
                                            
                                            $totalAccounted = $totalReturned + $wasteScrapReturned + $wasteNotRecoverable;
                                            $remainingQty = max(0, $item->total_qty - $totalAccounted);

                                            $returnedPieces = max(0, $item->returns->sum('piece_returned'));
                                            $remainingpiece = max(0, $item->piece_no - $returnedPieces);
                                            $status = ($remainingQty <= 0.001) ? 'Completed' : 'Pending';
                                        @endphp
                                        <tr>
                                            <td class="text-secondary">{{ $key + 1 }}</td>
                                            <td class="fw-bold text-dark">{{ $item->item_name }}</td>
                                            <td>{{ number_format($item->total_qty, 3) }}</td>
                                            <td class="{{ $totalReturned > 0 ? 'text-success' : 'text-muted' }}">{{ number_format($totalReturned, 3) }}</td>
                                            <td>{{ number_format($wasteScrapReturned, 3) }}</td>
                                            <td>{{ number_format($wasteNotRecoverable, 3) }}</td>
                                            <td>{{ $item->piece_no ?? 0 }}</td>
                                            <td class="{{ $returnedPieces > 0 ? 'text-success fw-bold' : 'text-muted' }}">{{ $returnedPieces }}</td>
                                            <td class="fw-bold {{ $remainingpiece > 0 ? 'text-primary' : 'text-muted' }}">{{ $remainingpiece }}</td>
                                            <td>
                                                {{ optional($item->returns->first())->despatch_date 
                                                    ? \Carbon\Carbon::parse($item->returns->first()->despatch_date)->format('d/m/Y') 
                                                    : '-' }}
                                            </td>
                                            <td>
                                                @if($status == 'Completed')
                                                    <span class="badge-completed">Completed</span>
                                                @else
                                                    <span class="badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#updateReturnModal-{{ $item->id }}" class="btn-return popup-content">
                                                    <i class="bi bi-arrow-return-left me-1"></i> Return
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Section (Outside Container) -->
@foreach($challan->items as $key => $item)
@php
    $totalReturnedModal = max(0, $item->returns->sum('quantity_returned'));
    $wasteScrapModal = max(0, $item->returns->sum('waste_scrap_returned'));
    $wasteNotRecoverableModal = max(0, $item->returns->sum('waste_not_recoverable'));
    $totalAccountedModal = $totalReturnedModal + $wasteScrapModal + $wasteNotRecoverableModal;
    $remainingQtyModal = max(0, $item->total_qty - $totalAccountedModal);
    $returnedPcsModal = max(0, $item->returns->sum('piece_returned'));
    $remainingPcsModal = max(0, $item->piece_no - $returnedPcsModal);
@endphp
<div id="updateReturnModal-{{ $item->id }}" class="white-popup mfp-hide">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h5 class="fw-bold text-dark mb-2">Return Item</h5>
            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap" style="font-size: 0.9rem;">
                <span class="fw-bold text-dark me-1">{{ $item->item_name }}</span>
                <span class="badge-sent-modal">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Sent: {{ number_format($item->total_qty, 3) }} KG ({{ $item->piece_no ?? 0 }} Pcs)
                </span>
                <span class="badge bg-light text-success border px-2 py-1" style="border-radius: 20px; font-size: 0.82rem; font-weight: 700;">
                    <i class="bi bi-check2-circle me-1"></i>Returned: {{ number_format($totalReturnedModal, 3) }} KG ({{ $returnedPcsModal }} Pcs)
                </span>
                <span class="badge-remaining-modal {{ $remainingQtyModal <= 0.001 ? 'remaining-zero' : 'remaining-active' }}">
                    <i class="bi bi-hourglass-split me-1"></i>Remaining: {{ number_format($remainingQtyModal, 3) }} KG ({{ $remainingPcsModal }} Pcs)
                </span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('return-items.store') }}" class="return-form" data-remaining="{{ $remainingQtyModal }}">
        @csrf
        <input type="hidden" name="challan_item_id" value="{{ $item->id }}">

        <!-- Dynamic Error Alert -->
        <div class="modal-error-alert alert alert-danger d-none align-items-center gap-2 mb-3" style="border-radius: 8px; border: 1px solid #fecdd3; background-color: #fff1f2; color: #e11d48;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span class="error-msg fw-semibold"></span>
        </div>

        <div class="row g-3">
            <!-- Row 1 -->
            <div class="col-md-6">
                <label class="form--label">Subsidiary Challan No.</label>
                <input type="text" class="form--control" name="subsidiary_challan_number" value="{{ old('subsidiary_challan_number', $item->subsidiary_challan_number) }}">
            </div>
            <div class="col-md-6">
                <label class="form--label">Date</label>
                <input type="date" class="form--control" name="despatch_date" value="{{ old('despatch_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>

            <!-- Row 2 -->
            <div class="col-md-6">
                <label class="form--label">Quantity Returned (KG)</label>
                <input type="number" step="0.001" class="form--control" name="quantity_returned" value="{{ old('quantity_returned', $item->quantity_returned) }}" placeholder="0.000">
            </div>
            <div class="col-md-6">
                <label class="form--label">Pieces Returned</label>
                <input type="number" class="form--control" name="piece_returned" value="{{ old('piece_returned', $item->piece_returned) }}" placeholder="0">
            </div>

            <!-- Row 3 -->
            <div class="col-md-6">
                <label class="form--label">Waste Scrap (KG)</label>
                <input type="number" step="0.001" class="form--control" name="waste_scrap_returned" value="{{ old('waste_scrap_returned', $item->waste_scrap_returned) }}" placeholder="0.000">
            </div>
            <div class="col-md-6">
                <label class="form--label">Unrecoverable Waste (KG)</label>
                <input type="number" step="0.001" class="form--control" name="waste_not_recoverable" value="{{ old('waste_not_recoverable', $item->waste_not_recoverable) }}" placeholder="0.000">
            </div>

            <!-- Notes -->
            <div class="col-12">
                <label class="form--label">Notes</label>
                <textarea name="return_notes" class="form--control" rows="3" placeholder="Optional notes...">{{ old('return_notes', $item->return_notes) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="col-12 text-center mt-4">
                <button type="submit" class="modal-btn px-5">Save Return</button>
            </div>
        </div>
    </form>
</div>
@endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#challanTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search items...",
            "paginate": {
                "next": "<i class='bi bi-chevron-right'></i>",
                "previous": "<i class='bi bi-chevron-left'></i>"
            }
        }
    });

    $('.popup-content').magnificPopup({
        type: 'inline',
        midClick: true,
        mainClass: 'mfp-fade',
        removalDelay: 100,
        callbacks: {
            open: function() {
                const modal = $(this.content);
                setTimeout(function() {
                    const firstInput = modal.find('input[type="text"]:visible, input[type="number"]:visible, select:visible, textarea:visible').first();
                    if (firstInput.length) {
                        firstInput.focus().select();
                    }
                }, 50);
            }
        }
    });

    @if(!session()->has('success') && !session()->has('error'))
    // Auto-open return modal ONLY on fresh page navigation
    setTimeout(function() {
        const firstReturnBtn = $('.btn-return.popup-content:visible').first();
        if (firstReturnBtn.length) {
            firstReturnBtn.click();
        }
    }, 150);
    @endif

    // Enter Key Navigation inside Return Form:
    // Field 1 -> Enter -> Field 2 -> Enter -> Last Field -> Enter -> AUTOMATIC SAVE & SUBMIT!
    $(document).on('keydown', '.return-form input', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const form = $(this).closest('form');
            const inputs = form.find('input[type="text"]:visible, input[type="number"]:visible, select:visible, textarea:visible');
            const index = inputs.index(this);

            if (index >= 0 && index < inputs.length - 1) {
                inputs.eq(index + 1).focus().select();
            } else {
                // Submit form immediately on last input
                form.submit();
            }
        }
    });

    // Validate Return Form against Remaining Quantity
    $('.return-form').on('submit', function(e) {
        var form = $(this);
        var remainingQty = parseFloat(form.data('remaining')) || 0;

        var qtyReturned = parseFloat(form.find('input[name="quantity_returned"]').val()) || 0;
        var wasteScrap = parseFloat(form.find('input[name="waste_scrap_returned"]').val()) || 0;
        var wasteUnrecoverable = parseFloat(form.find('input[name="waste_not_recoverable"]').val()) || 0;

        var totalEntered = qtyReturned + wasteScrap + wasteUnrecoverable;

        // Reset previous error state
        var errorBox = form.find('.modal-error-alert');
        errorBox.addClass('d-none').removeClass('d-flex');
        form.find('.form--control').removeClass('is-invalid');

        if (totalEntered > (remainingQty + 0.0001)) {
            e.preventDefault();
            
            var msg = 'Quantity Exceeded! Total entered (' + totalEntered.toFixed(3) + ' KG) exceeds remaining allowed quantity (' + remainingQty.toFixed(3) + ' KG). Cannot save!';
            
            // Show error box in modal
            errorBox.find('.error-msg').text(msg);
            errorBox.removeClass('d-none').addClass('d-flex');
            
            // Highlight input fields
            if (qtyReturned > 0) form.find('input[name="quantity_returned"]').addClass('is-invalid');
            if (wasteScrap > 0) form.find('input[name="waste_scrap_returned"]').addClass('is-invalid');
            if (wasteUnrecoverable > 0) form.find('input[name="waste_not_recoverable"]').addClass('is-invalid');
            if (totalEntered === 0) form.find('input[name="quantity_returned"]').addClass('is-invalid');

            // Show error dialog box
            alert('⚠️ Cannot Save Return:\n\n' + msg);
            return false;
        }
    });
});
</script>
@endpush
