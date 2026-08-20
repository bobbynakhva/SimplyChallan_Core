@extends('layout.app')

@section('title', 'Manage Challans')

@push('styles')
<style>
    /* === MODERN EXECUTIVE LIGHT THEME === */
    body, .page-wrapper {
        background-color: #f8fafc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #0f172a;
    }

    /* GLOBAL FOCUS RESET */
    *:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    /* === SIDEBAR REFINEMENT === */
    ul.common__sidebar__wrapper {
        background-color: #ffffff !important;
        border-radius: 16px;
        padding: 24px 14px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        gap: 10px;
        border: 1px solid #e2e8f0;
        margin-top: 30px;
    }
    
    .side__sticky {
        position: sticky;
        top: 100px !important;
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
        padding: 12px 18px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        border-radius: 10px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        letter-spacing: 0.02em;
    }

    .sidebar-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        transform: translateX(4px);
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.35);
        font-weight: 700;
    }
    
    .sidebar-link i {
        font-size: 1.15rem;
        width: 24px;
        text-align: center;
    }

    /* === FLEX LAYOUT & UNBOXED PAGE CONTENT === */
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
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 110px 40px 40px 0 !important;
        box-sizing: border-box !important;
    }

    @media (max-width: 1199px) {
        .common__body {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 20px 15px !important;
        }
    }

    /* === UNBOXED PAGE CONTENT CONTAINER === */
    .challan-card {
        background-color: transparent !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin-bottom: 30px !important;
        border: none !important;
        width: 100% !important;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.03em;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 4px;
    }

    /* Action Buttons */
    .btn-gold {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }
    .btn-gold:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
    }

    .btn-bulk-import-outline {
        border: 1.5px solid #cbd5e1;
        color: #475569;
        background-color: #ffffff;
        border-radius: 10px;
        font-weight: 700;
        padding: 9px 20px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        transition: all 0.2s ease;
        margin-right: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-bulk-import-outline:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* Metric Summary Bar */
    .summary-metrics-bar {
        display: flex;
        gap: 20px;
        margin-bottom: 24px;
    }
    .metric-chip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
    }
    .metric-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .metric-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.04em;
    }
    .metric-value {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    #challanTable {
        width: 100% !important;
        border-collapse: collapse;
        margin: 0 !important;
    }
    #challanTable thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 16px 18px;
        border-bottom: 2px solid #e2e8f0;
        border-right: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    #challanTable tbody td {
        background-color: #ffffff;
        color: #334155;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f8fafc;
        vertical-align: middle;
    }
    #challanTable thead th:last-child,
    #challanTable tbody td:last-child {
        border-right: none;
    }
    #challanTable tbody tr {
        transition: background-color 0.15s ease;
    }
    #challanTable tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge-purpose {
        background-color: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    /* KGS Sent & Received Inverse Badges */
    .badge-kgs-sent {
        background-color: #eef2ff;
        color: #3730a3;
        border: 1.5px solid #c7d2fe;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 1px 3px rgba(55, 48, 163, 0.08);
    }

    .badge-kgs-received {
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-kgs-received.received-active {
        background-color: #ecfdf5;
        color: #047857;
        border: 1.5px solid #a7f3d0;
        box-shadow: 0 1px 3px rgba(4, 120, 87, 0.08);
    }
    .badge-kgs-received.received-zero {
        background-color: #f8fafc;
        color: #94a3b8;
        border: 1.5px solid #e2e8f0;
    }

    /* Action Toolbar Buttons */
    .btn-action-group {
        display: inline-flex;
        gap: 8px;
        background: #ffffff;
        padding: 6px 10px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    }
    .btn-icon-pill {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid transparent;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        font-size: 1.15rem;
    }
    .btn-icon-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }
    
    .btn-view-pill { color: #0284c7; background: #f0f9ff; border-color: #bae6fd; }
    .btn-view-pill:hover { background: #0284c7; color: #ffffff; border-color: #0284c7; }

    .btn-print-pill { color: #4f46e5; background: #eeefee; border-color: #c7d2fe; }
    .btn-print-pill:hover { background: #4f46e5; color: #ffffff; border-color: #4f46e5; }

    .btn-items-pill { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
    .btn-items-pill:hover { background: #059669; color: #ffffff; border-color: #059669; }

    .btn-edit-pill { color: #d97706; background: #fffbeb; border-color: #fde68a; }
    .btn-edit-pill:hover { background: #f59e0b; color: #ffffff; border-color: #f59e0b; }

    .btn-delete-pill { color: #e11d48; background: #fff1f2; border-color: #fecdd3; }
    .btn-delete-pill:hover { background: #e11d48; color: #ffffff; border-color: #e11d48; }

    /* DataTables Pagination & Controls */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 8px 16px !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f59e0b !important;
        border-color: #f59e0b !important;
        color: white !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fef3c7 !important;
        border-color: #fcd34d !important;
        color: #92400e !important;
        border-radius: 8px !important;
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
                    <!-- NEW CHALLAN -->
                    <li class="common__sideitems">
                        <a href="{{ route('challan.create') }}" class="sidebar-link {{ request()->routeIs('challan.create') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>New Challan</span>
                        </a>
                    </li>
                    <!-- MANAGE -->
                    <li class="common__sideitems">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid"></i>
                            <span>Manage Challan</span>
                        </a>
                    </li>
                    <!-- REPORTS -->
                    <li class="common__sideitems">
                        <a href="{{ route('challan.reports') }}" class="sidebar-link {{ request()->routeIs('challan.reports') ? 'active' : '' }}">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <!-- PURPOSE -->
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
                
                <!-- Unboxed Page Content -->
                <div class="challan-card w-100">
                    
                    <!-- Header -->
                    <div class="page-header">
                        <div>
                            <h4 class="page-title">Manage Challans</h4>
                            <div class="page-subtitle">View, print, and manage your outward delivery challans</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn-bulk-import-outline" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                                <i class="bi bi-file-earmark-arrow-up"></i> Bulk Import
                            </button>
                            <a href="{{ route('challan.create') }}" class="btn-gold">
                                <i class="bi bi-plus-lg"></i> Add Challan
                            </a>
                        </div>
                    </div>

                    <!-- Summary Metrics Bar -->
                    @php
                        $totalSentKgs = 0;
                        $totalReturnedKgs = 0;
                        $totalSentPcs = 0;
                        $totalReturnedPcs = 0;
                        foreach($challans as $challan) {
                            foreach($challan->items as $item) {
                                $totalSentKgs += (float)$item->total_qty;
                                $totalReturnedKgs += (float)$item->returns->sum('quantity_returned');
                                $totalSentPcs += (int)$item->piece_no;
                                $totalReturnedPcs += (int)$item->returns->sum('piece_returned');
                            }
                        }
                    @endphp
                    <div class="summary-metrics-bar">
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#e0f2fe; color:#0284c7;">
                                <i class="bi bi-files"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Outward Challans</div>
                                <div class="metric-value">{{ count($challans) }}</div>
                            </div>
                        </div>
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#ecfdf5; color:#059669;">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Sent</div>
                                <div class="metric-value">{{ number_format($totalSentKgs, 3) }} kg <span class="fs-6 fw-normal text-muted">({{ $totalSentPcs }} Pcs)</span></div>
                            </div>
                        </div>
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#fef3c7; color:#d97706;">
                                <i class="bi bi-arrow-return-left"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Returned</div>
                                <div class="metric-value">{{ number_format($totalReturnedKgs, 3) }} kg <span class="fs-6 fw-normal text-muted">({{ $totalReturnedPcs }} Pcs)</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Import Modal -->
                    <div class="modal fade" id="bulkImportModal" tabindex="-1" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 20px 24px;">
                                    <h5 class="modal-title fw-bold" id="bulkImportModalLabel" style="color:#0f172a;">Bulk Import Challans</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('challan.bulkImport') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body" style="padding: 24px;">
                                        <div class="mb-3">
                                            <label for="excel_file" class="form-label fw-semibold" style="color:#334155;">Choose Excel or CSV File</label>
                                            <input type="file" class="form-control" name="excel_file" id="excel_file" required style="border-radius: 10px; padding: 10px;">
                                            <div class="form-text text-muted small mt-1">Supported file formats: .xlsx, .xls, .csv</div>
                                        </div>
                                        <div class="alert alert-info border-0 rounded-3 d-flex align-items-center gap-2" style="background:#f0f9ff; color:#0369a1;">
                                            <i class="bi bi-info-circle-fill fs-5"></i>
                                            <span>Download the sample template below to ensure correct formatting.</span>
                                        </div>
                                        <a href="{{ route('challan.sampleDownload') }}" class="btn btn-sm btn-link text-decoration-none fw-bold p-0" style="color:#0284c7;">
                                            <i class="bi bi-download me-1"></i> Download Sample Excel Template
                                        </a>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                                        <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Close</button>
                                        <button type="submit" class="btn-gold" style="box-shadow: none;">Upload & Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-middle" id="challanTable">
                            <thead>
                                <tr>
                                    <th>Challan No</th>
                                    <th>Client Name</th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Sent (Kgs / Pcs)</th>
                                    <th>Returned (Kgs / Pcs)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($challans as $challan)
                                @php
                                    $sentKgs = $challan->items ? $challan->items->sum('total_qty') : 0;
                                    $sentPcs = $challan->items ? $challan->items->sum('piece_no') : 0;
                                    $receivedKgs = 0;
                                    $receivedPcs = 0;
                                    if ($challan->items) {
                                        foreach ($challan->items as $item) {
                                            if ($item->returns) {
                                                $receivedKgs += $item->returns->sum('quantity_returned');
                                                $receivedPcs += $item->returns->sum('piece_returned');
                                            }
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td class="fw-bold" style="color:#0f172a;">{{ $challan->challan_number }}</td>
                                    <td class="fw-semibold" style="color:#334155;">{{ $challan->industry_name ?? optional($challan->company)->industry_name ?? '-' }}</td>
                                    <td style="color:#475569;">{{ date('d-m-Y', strtotime($challan->date)) }}</td>
                                    <td>
                                        <span class="badge-purpose">
                                            {{ optional($challan->purpose)->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-kgs-sent">
                                            <i class="bi bi-box-arrow-up-right" style="font-size: 0.75rem;"></i>
                                            {{ number_format($sentKgs, 3) }} kg ({{ $sentPcs }} Pcs)
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-kgs-received {{ $receivedKgs > 0 ? 'received-active' : 'received-zero' }}">
                                            <i class="bi bi-box-arrow-in-down-left" style="font-size: 0.75rem;"></i>
                                            {{ number_format($receivedKgs, 3) }} kg ({{ $receivedPcs }} Pcs)
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-action-group">
                                            <!-- View -->
                                            <a href="{{ route('challan.view', $challan->id) }}" class="btn-icon-pill btn-view-pill" title="View Challan">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!-- Print -->
                                            <a href="{{ route('challan.print', $challan->id) }}" class="btn-icon-pill btn-print-pill" title="Print Challan">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                            <!-- Item Details -->
                                            <a href="{{ route('challan.items', $challan->id) }}" class="btn-icon-pill btn-items-pill" title="View Items">
                                                <i class="bi bi-box-seam"></i>
                                            </a> 
                                            <!-- Edit -->
                                            <a href="{{ route('challan.edit', $challan->id) }}" class="btn-icon-pill btn-edit-pill" title="Edit Challan">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('challan.softDelete', $challan->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon-pill btn-delete-pill" onclick="return confirm('Are you sure you want to delete this challan?');" title="Delete Challan">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
            "searchPlaceholder": "Search challans...",
            "paginate": {
                "next": "<i class='bi bi-chevron-right'></i>",
                "previous": "<i class='bi bi-chevron-left'></i>"
            }
        }
    });
});
</script>
@endpush
