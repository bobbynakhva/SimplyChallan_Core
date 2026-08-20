@extends('layout-inward.app')

@section('title', 'Manage Challan Items')

@push('styles')
<style>
    /* Professional Theme - Gold & White/Grey */
    body, .page-wrapper {
        background-color: #f7f9fc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #1e293b;
    }

    /* === GLOBAL FOCUS RESET (KILL THE BLUE) === */
    *:focus {
        outline: none !important;
        box-shadow: none !important; 
    }

    /* Main Card */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 30px;
        margin: 30px auto;
        border: 1px solid #e2e8f0;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.025em;
        margin: 0;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
    #challanTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
    }
    #challanTable thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 16px 20px;
        border-bottom: 2px solid #e2e8f0;
        border-top: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    #challanTable tbody td {
        background-color: #ffffff;
        color: #334155;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    #challanTable tbody tr:last-child td {
        border-bottom: none;
    }
    #challanTable tbody tr:hover td {
        background-color: #fdfdfd;
    }

    /* Badges */
    .badge-pill {
        display: inline-block;
        border-radius: 9999px;
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.025em;
        text-transform: uppercase;
        line-height: 1;
    }
    .badge-success {
        background-color: #ecfdf5;
        color: #059669;
        border: 1px solid #d1fae5;
    }
    .badge-warning {
        background-color: #fffbeb;
        color: #d97706;
        border: 1px solid #fef3c7;
    }

    /* Action Buttons */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: #64748b;
        background: #f8fafc;
        text-decoration: none;
    }
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        color: #1e293b;
    }
    .btn-print:hover {
        background-color: #ecfdf5;
        color: #059669;
        border-color: #d1fae5;
    }
    .btn-return:hover {
        background-color: #fffbeb;
        color: #d97706;
        border-color: #fcd34d;
    }
    .btn-history:hover {
        background-color: #eff6ff;
        color: #3b82f6;
        border-color: #bfdbfe;
    }

    /* Modal Styling */
    .white-popup {
        position: relative;
        background: #FFF;
        padding: 40px;
        width: auto;
        max-width: 650px;
        margin: 20px auto;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
        display: block;
        margin-top: 4px;
    }

    /* Modal Form Elements */
    .form--label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        display: block;
    }
    .form--control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
        color: #1e293b;
        transition: all 0.2s;
    }
    .form--control:focus {
        border-color: #f59e0b !important;
        /* Soft Gold Pulse */
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important;
    }

    /* === NEAT PULSE ANIMATION === */
    @keyframes pulse-gold {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
    @keyframes pulse-grey {
        0% { box-shadow: 0 0 0 0 rgba(100, 116, 139, 0.2); }
        70% { box-shadow: 0 0 0 6px rgba(100, 116, 139, 0); }
        100% { box-shadow: 0 0 0 0 rgba(100, 116, 139, 0); }
    }

    /* Modal Buttons: Primary Gold */
    .cmn__btn {
        background-color: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 10px 32px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        position: relative;
        overflow: hidden; /* For ripple containment if needed */
    }
    .cmn__btn:hover {
        background-color: #b45309; 
    }
    .cmn__btn:active {
        transform: scale(0.98);
        background-color: #92400e;
    }
    /* Gold Pulse on Focus/Click */
    .cmn__btn:active, .cmn__btn:focus {
        animation: pulse-gold 0.6s ease-out;
    }

    /* Close/Cancel Button Refined */
    .cmn__btn.close-mfp {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        margin-left: 12px;
    }
    .cmn__btn.close-mfp:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    /* Grey Pulse on Focus/Click */
    .cmn__btn.close-mfp:active, .cmn__btn.close-mfp:focus {
        animation: pulse-grey 0.6s ease-out;
        border-color: #cbd5e1;
    }

    /* Add Row Button */
    .btn-add-more {
        width: 100%;
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-add-more:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }
    .btn-add-more:active {
        animation: pulse-grey 0.4s ease-out;
    }

    /* Remove Row Button */
    .btn-danger-soft {
        background-color: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        width: 100%;
        height: 100%;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-danger-soft:hover {
        background-color: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    /* Datatable Focus Fixes */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f59e0b !important;
        border-color: #f59e0b !important;
        color: white !important;
        border-radius: 6px;
        font-weight: 700;
        box-shadow: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fef3c7 !important;
        border-color: #fcd34d !important;
        color: #92400e !important;
        box-shadow: none !important;
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
            @include('layout-inward.sidebar')
            <div class="common__body">
                
                <div class="container">
                    <div class="challan-card">
                        
                        <!-- Header -->
                        <div class="page-header">
                            <div>
                                <h4 class="page-title">Manage Inward Challan Items</h4>
                                <span class="text-muted small">View and manage items for this challan</span>
                            </div>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert" style="border-radius: 8px; border: 1px solid #fecdd3; background-color: #fff1f2; color: #e11d48;">
                                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert" style="border-radius: 8px; border: 1px solid #a7f3d0; background-color: #ecfdf5; color: #047857;">
                                <i class="bi bi-check-circle-fill fs-5"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Total Qty (Kgs)</th>
                                        <th>Qty Used</th>
                                        <th>Total Pcs</th>
                                        <th>Returned Pcs</th>
                                        <th>Remaining Pcs</th> 
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($challan->inwarditems as $key => $item)
                                        @php
                                            $totalReturned = max(0, $item->goodsStocks->sum('kgs'));
                                            $returnedPieces = max(0, $item->goodsStocks->sum('pcs'));
                                            $remainingQty = max(0, $item->qty - $totalReturned);
                                            $remainingpiece = max(0, $item->piece_no - $returnedPieces);
                                            $status = ($remainingQty <= 0) ? 'Completed' : 'Pending';
                                            $lastStock = $item->goodsStocks->sortByDesc('id')->first();
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-muted">{{ $key + 1 }}</td>
                                            <td class="fw-bold text-dark">{{ $item->item_name }}</td>
                                            <td>{{ number_format($item->qty, 3) }}</td>
                                            <td>{{ number_format($totalReturned, 3) }}</td>
                                            <td>{{ $item->piece_no ?? 0 }}</td>
                                            <td class="{{ $returnedPieces > 0 ? 'text-success fw-bold' : 'text-muted' }}">{{ $returnedPieces }}</td>
                                            <td class="fw-bold {{ $remainingpiece > 0 ? 'text-primary' : 'text-muted' }}">{{ $remainingpiece }}</td>
                                            <td>
                                                @if($status == 'Completed')
                                                    <span class="badge-pill badge-success">Completed</span>
                                                @else
                                                    <span class="badge-pill badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                @if($lastStock)
                                                    <a href="{{ route('inward.challan.invoice', $lastStock->id) }}" target="_blank" class="btn-action btn-print" title="Print Recent Invoice">
                                                        <i class="bi bi-printer"></i>
                                                    </a>
                                                @endif
                                                @if($item->goodsStocks->count() > 0)
                                                     <a href="#historyModal-{{ $item->id }}" class="btn-action btn-history popup-content" title="View History">
                                                        <i class="bi bi-clock-history"></i>
                                                    </a>
                                                @endif
                                                @if($item->qty > 0)
                                                    <a href="#updateReturnModal-{{ $item->id }}" class="btn-action btn-return popup-content" title="Return Items">
                                                        <i class="bi bi-box-seam"></i>
                                                    </a>
                                                @endif
                                                </div>
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
</div>

<!-- Modals -->
@foreach($challan->inwarditems as $key => $item)
@php
    $totalReturnedInwardModal = max(0, $item->goodsStocks->sum('kgs'));
    $returnedPcsInwardModal = max(0, $item->goodsStocks->sum('pcs'));
    $remainingQtyInwardModal = max(0, $item->qty - $totalReturnedInwardModal);
    $remainingPcsInwardModal = max(0, $item->piece_no - $returnedPcsInwardModal);
@endphp
<div id="updateReturnModal-{{ $item->id }}" class="white-popup mfp-hide">
    <div class="modal-header-custom mb-3">
        <h5 class="modal-title mb-2">Return Prepared Items</h5>
        <div class="modal-subtitle d-flex flex-wrap gap-2 align-items-center">
            <span class="fw-bold text-dark fs-6 me-2">{{ $item->item_name }}</span>
            <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.8rem;">
                <i class="bi bi-box-arrow-up-right me-1"></i>Total Sent: <strong>{{ number_format($item->qty, 3) }} KG</strong> ({{ $item->piece_no ?? 0 }} Pcs)
            </span>
            <span class="badge bg-light text-success border border-success-subtle px-2 py-1" style="font-size: 0.8rem;">
                <i class="bi bi-check2-circle me-1"></i>Returned: <strong>{{ number_format($totalReturnedInwardModal, 3) }} KG</strong> ({{ $returnedPcsInwardModal }} Pcs)
            </span>
            <span class="badge bg-light text-warning border border-warning-subtle px-2 py-1" style="font-size: 0.8rem; color: #b45309 !important;">
                <i class="bi bi-hourglass-split me-1"></i>Remaining: <strong>{{ number_format($remainingQtyInwardModal, 3) }} KG</strong> ({{ $remainingPcsInwardModal }} Pcs)
            </span>
        </div>
    </div>
    
    <form method="POST" action="{{ route('inward.return-items.store') }}" class="inward-return-form" data-remaining="{{ $remainingQtyInwardModal }}">
        @csrf
        <input type="hidden" name="inward_challan_items_id" value="{{ $item->id }}">
        
        <!-- Dynamic Error Alert inside Modal -->
        <div class="modal-error-alert alert alert-danger d-none align-items-center gap-2 mb-3" style="border-radius: 8px; border: 1px solid #fecdd3; background-color: #fff1f2; color: #e11d48;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span class="error-msg fw-semibold"></span>
        </div>
        
        <div id="return-items-container-{{ $item->id }}">
            <div class="row g-2 return-item-row mb-2 align-items-end">
                <div class="col-5">
                    <label class="form--label">Item Name</label>
                    <input type="text" class="form--control" name="items[0][item_name]" placeholder="Item Name (e.g. {{ $item->item_name }})">
                </div>
                <div class="col-3">
                    <label class="form--label">Qty (KG)</label>
                    <input type="number" class="form--control" name="items[0][kgs]" placeholder="0.00" step="0.01">
                </div>
                <div class="col-3">
                    <label class="form--label">Pieces</label>
                    <input type="number" class="form--control" name="items[0][pcs]" placeholder="0">
                </div>
                <div class="col-1">
                    <div style="padding-bottom:1px;">
                        <button type="button" class="btn-add-more add-more-btn" data-item-id="{{ $item->id }}" style="height: 42px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
            <button type="button" class="cmn__btn close-mfp">Cancel</button>
            <button type="submit" class="cmn__btn">Save Return</button>
        </div>
    </form>
</div>
<div id="historyModal-{{ $item->id }}" class="white-popup mfp-hide">
    <div class="modal-header-custom">
        <h5 class="modal-title">
            Dispatch History
            <small class="modal-subtitle">
                {{ $item->item_name }}
            </small>
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="p-2 border-bottom">Date</th>
                    <th class="p-2 border-bottom">Challan No</th>
                    <th class="p-2 border-bottom">Details</th>
                    <th class="p-2 border-bottom text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->goodsStocks->sortByDesc('id') as $stock)
                    <tr>
                        <td class="p-2 border-bottom">{{ $stock->created_at->format('d-m-Y') }}</td>
                        <td class="p-2 border-bottom">{{ $stock->challan_number }}</td>
                        <td class="p-2 border-bottom">
                            <div>{{ $stock->kgs }} <small class="text-muted">Kg</small></div>
                            <div class="small text-muted">{{$stock->pcs}} Pcs</div>
                        </td>
                        <td class="p-2 border-bottom text-end">
                             <a href="{{ route('inward.challan.invoice', $stock->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-end mt-3 pt-2 border-top">
         <button type="button" class="cmn__btn close-mfp">Close</button>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#challanTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
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
        removalDelay: 300
    });

    $(document).on('click', '.close-mfp', function () {
        $.magnificPopup.close();
    });

    // Dynamic Row Logic
    document.querySelectorAll('.add-more-btn').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');
            const container = document.getElementById(`return-items-container-${itemId}`);
            const rowCount = container.querySelectorAll('.return-item-row').length;
            
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'g-2', 'return-item-row', 'mb-2', 'align-items-end');
            newRow.innerHTML = `
                <div class="col-5">
                    <input type="text" name="items[${rowCount}][item_name]" class="form--control" placeholder="Item Name">
                </div>
                <div class="col-3">
                    <input type="number" name="items[${rowCount}][kgs]" class="form--control" placeholder="KGs" step="0.01">
                </div>
                <div class="col-3">
                    <input type="number" name="items[${rowCount}][pcs]" class="form--control" placeholder="Pcs">
                </div>
                <div class="col-1">
                    <div style="padding-bottom:1px;">
                        <button type="button" class="btn-danger-soft remove-row-btn" style="height: 42px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row-btn')) {
            e.target.closest('.return-item-row').remove();
        }
    });

    // Validate Inward Return Form against Remaining Quantity
    $('.inward-return-form').on('submit', function(e) {
        var form = $(this);
        var remainingQty = parseFloat(form.data('remaining')) || 0;

        var totalEnteredKgs = 0;
        form.find('input[name*="[kgs]"]').each(function() {
            var val = parseFloat($(this).val()) || 0;
            totalEnteredKgs += val;
        });

        // Reset previous error state
        var errorBox = form.find('.modal-error-alert');
        errorBox.addClass('d-none').removeClass('d-flex');
        form.find('.form--control').removeClass('is-invalid');

        if (totalEnteredKgs > (remainingQty + 0.0001)) {
            e.preventDefault();
            
            var msg = 'Quantity Exceeded! Total entered (' + totalEnteredKgs.toFixed(3) + ' KG) exceeds available remaining quantity (' + remainingQty.toFixed(3) + ' KG). Cannot save!';
            
            // Show error box in modal
            errorBox.find('.error-msg').text(msg);
            errorBox.removeClass('d-none').addClass('d-flex');
            
            // Highlight input fields
            form.find('input[name*="[kgs]"]').each(function() {
                if ((parseFloat($(this).val()) || 0) > 0) {
                    $(this).addClass('is-invalid');
                }
            });

            // Show error dialog box
            alert('⚠️ Cannot Save Return:\n\n' + msg);
            return false;
        }
    });
});
</script>
@endpush
