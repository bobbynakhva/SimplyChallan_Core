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

    /* === MAIN CARD === */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
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
        overflow: hidden;
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
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 16px 12px;
        border-bottom: 2px solid #e2e8f0;
        border-top: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    #challanTable tbody td {
        background-color: #ffffff;
        color: #334155;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
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

    /* Modal Styling */
    .white-popup {
        background: #FFF;
        padding: 30px;
        width: auto;
        max-width: 700px;
        margin: 20px auto;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
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
            <div class="common__body">
                <div class="container">
                    <div class="challan-card">
                        
                        <!-- Header -->
                        <div class="page-header">
                            <div>
                                <h4 class="page-title">Manage Challan Items</h4>
                                <span class="text-muted small">Detail view of challan items and returns</span>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Total Sent (kg)</th>
                                        <th>Returned (kg)</th>
                                        <th>Waste/Scrap (kg)</th>
                                        <th>Unrecoverable (kg)</th>
                                        <th>Pieces</th>
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

                                            $remainingpiece = max(0, $item->piece_no - $item->returns->sum('piece_returned'));
                                            $status = ($remainingQty <= 0.001) ? 'Completed' : 'Pending';
                                        @endphp
                                        <tr>
                                            <td class="text-secondary">{{ $key + 1 }}</td>
                                            <td class="fw-bold text-dark">{{ $item->item_name }}</td>
                                            <td>{{ number_format($item->total_qty, 3) }}</td>
                                            <td class="{{ $totalReturned > 0 ? 'text-success' : 'text-muted' }}">{{ number_format($totalReturned, 3) }}</td>
                                            <td>{{ number_format($wasteScrapReturned, 3) }}</td>
                                            <td>{{ number_format($wasteNotRecoverable, 3) }}</td>
                                            <td>{{ $remainingpiece }}</td>
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
</div>

<!-- Modal Section (Outside Container) -->
@foreach($challan->items as $key => $item)
<div id="updateReturnModal-{{ $item->id }}" class="white-popup mfp-hide">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h5 class="fw-bold text-dark">Return Item</h5>
            <div class="text-muted">{{ $item->item_name }} (Sent: {{ $item->total_qty }} KG)</div>
        </div>
    </div>

    <form method="POST" action="{{ route('return-items.store') }}">
        @csrf
        <input type="hidden" name="challan_item_id" value="{{ $item->id }}">

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
        mainClass: 'mfp-fade'
    });
});
</script>
@endpush
