@extends('layout.app')

@section('title', 'Manage Report Challan')

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
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Filters Bar */
    .filters-bar {
        background-color: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .filter-select {
        border-radius: 50px;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        font-size: 0.9rem;
        min-width: 200px;
    }

    .btn-export {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-export:hover {
        background-color: #059669;
        color: white;
        transform: translateY(-1px);
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

    /* Form Checkbox */
    .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
    }
    .form-check-input:checked {
        background-color: #f59e0b;
        border-color: #f59e0b;
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

    /* Action Buttons */
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 0.9rem;
        margin: 0 2px;
    }
    .btn-edit { color: #d97706; background: #fffbeb; border-color: #fcd34d; }
    .btn-edit:hover { background: #f59e0b; color: white; border-color: #f59e0b; }
    
    .btn-view { color: #0ea5e9; background: #e0f2fe; border-color: #bae6fd; }
    .btn-view:hover { background: #0ea5e9; color: white; border-color: #0ea5e9; }

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
            <div class="common__body flex-grow-1 min-vw-0">
                <!-- Unboxed Page Content -->
                <div class="challan-card w-100">
                        
                        <!-- Header -->
                        <div class="page-header">
                            <div>
                                <h4 class="page-title">Manage Report Challan</h4>
                                <span class="text-muted small">Track status & exports</span>
                            </div>
                        </div>

                        <!-- EXPORT TOOLBAR -->
                        <div class="filters-bar">
                            <div class="form-group mb-0">
                                <select id="companyFilter" class="form-select filter-select">
                                    <option value="">All Companies</option>
                                    @if(isset($companies))
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->industry_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <button class="btn-export" onclick="exportData(false)">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Export Filtered/All
                                </button>
                                <button class="btn-export" style="background-color: #3b82f6;" onclick="exportData(true)">
                                    <i class="bi bi-check-square"></i> Export Selected
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Challan No.</th>
                                        <th>Item Name</th>
                                        <th>Sent (kg)</th>
                                        <th>Returned (kg)</th>
                                        <th>Balance</th>
                                        <th>Pieces</th>
                                        <th>Despatch Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $ii = 0; @endphp
                                    @foreach($challans as $challan)
                                        @foreach($challan->items as $key => $item)
                                            @php
                                                $ii++;
                                                $totalActualReturned = $item->returns->sum('quantity_returned');
                                                $totalScrap = $item->returns->sum('waste_scrap_returned');
                                                $totalUnrecoverable = $item->returns->sum('waste_not_recoverable');
                                                
                                                $totalAccountedFor = $totalActualReturned + $totalScrap + $totalUnrecoverable;
                                                $remainingQty = max(0, $item->total_qty - $totalAccountedFor);
                                                
                                                $remainingpiece = max(0, $item->returns->sum('piece_returned'));
                                                $status = ($remainingQty <= 0.001) ? 'Completed' : 'Pending';
                                            @endphp
                                            <tr data-company-id="{{ $challan->company_id }}">
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input row-checkbox" value="{{ $challan->id }}">
                                                </td>
                                                <td class="text-secondary">{{ $ii }}</td>
                                                <td class="fw-bold">{{ strtoupper($challan->industry_name) }}</td>
                                                <td>{{ $challan->challan_number ?? '-' }}</td>
                                                <td class="text-dark fw-bold">{{ $item->item_name }}</td>
                                                <td>{{ number_format($item->total_qty, 3) }}</td>
                                                <td>{{ number_format($totalAccountedFor, 3) ?? '-' }}</td>
                                                <td class="{{ $remainingQty > 0.001 ? 'text-danger fw-bold' : 'text-success' }}">
                                                    {{ number_format($remainingQty, 3) ?? '-' }}
                                                </td>
                                                <td>{{ $remainingpiece ?? '-' }}</td>
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
                                                    <div class="d-flex">
                                                        <a href="{{ route('challan.returnreportsview', $challan->id) }}" class="btn-icon btn-view" title="View Report">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
        var table = $('#challanTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search reports...",
                "paginate": {
                    "next": "<i class='bi bi-chevron-right'></i>",
                    "previous": "<i class='bi bi-chevron-left'></i>"
                }
            }
        });

        // Filter by Company (Frontend visual filter logic using DataTables search or Custom)
        $('#companyFilter').on('change', function() {
            var selectedText = $(this).find("option:selected").text();
            if($(this).val() === "") {
                 table.column(2).search('').draw(); // Column 2 is Client Name
            } else {
                 table.column(2).search(selectedText).draw();
            }
        });

        // Select All Handler
        $('#selectAll').on('change', function() {
            $('.row-checkbox').prop('checked', $(this).is(':checked'));
        });
    });

    // Export Function
    function exportData(onlySelected) {
        var companyId = $('#companyFilter').val();
        var selectedIds = [];

        if (onlySelected) {
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });
            if (selectedIds.length === 0) {
                alert('Please select at least one record to export.');
                return;
            }
        }

        var url = "{{ route('challan.export') }}?company_id=" + companyId;
        
        if (onlySelected) {
             url += "&selected_ids=" + selectedIds.join(',');
        }

        window.location.href = url;
    }
</script>
@endpush
