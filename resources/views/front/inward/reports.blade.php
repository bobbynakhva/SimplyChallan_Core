@extends('layout-inward.app')
@section('title', 'Manage Inward Report')

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

    /* Action Buttons */
    .btn-view { color: #0ea5e9; background: #e0f2fe; border-color: #bae6fd; width: 32px; height: 32px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; border: 1px solid transparent; }
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
            @include('layout-inward.sidebar')

            <!-- MAIN CONTENT -->
            <div class="common__body">
                <div class="container">
                    <div class="challan-card">
                        
                        <!-- Header -->
                        <div class="page-header">
                            <div>
                                <h4 class="page-title">Manage Inward Report</h4>
                                <span class="text-muted small">Overview of inward challans and items</span>
                            </div>
                        </div>

                         <!-- EXPORT TOOLBAR -->
                        <div class="filters-bar">
                            <div class="form-group mb-0">
                                <select id="companyFilter" class="form-select filter-select">
                                    <option value="">All Companies</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->industry_name }}</option>
                                    @endforeach
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

                        <!-- Content -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>#</th>
                                        <th>Client Company</th>
                                        <th>Main Challan No</th>
                                        <th>Item Name</th>
                                        <th>Total Qty</th>
                                        <th>Remaining Qty</th>
                                        <th>Returned Pieces</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $ii = 0; @endphp
                                    @foreach($challans as $challan)
                                        @foreach($challan->inwarditems as $key => $item)
                                            @php
                                                $totalReturned = max(0, $item->goodsStocks->sum('kgs'));
                                                $returnedPieces = max(0, $item->goodsStocks->sum('pcs'));
                                                $remainingQty = max(0, $item->qty - $totalReturned);
                                                $remainingpiece = max(0, $item->piece_no - $returnedPieces);
                                                $ii++;
                                            @endphp
                                            <tr data-company-id="{{ $challan->company_id }}">
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input row-checkbox" value="{{ $challan->id }}">
                                                </td>
                                                <td class="fw-bold text-muted">{{ $ii }}</td>
                                                <td class="fw-bold text-dark">{{ strtoupper($challan->industry_name) }}</td>
                                                <td>{{ $challan->main_challan_number }}</td>
                                                <td class="text-dark">{{ $item->item_name }}</td>
                                                <td class="fw-bold">{{ number_format($item->qty, 3) }}</td>
                                                <td class="{{ $remainingQty > 0 ? 'text-primary' : 'text-muted' }}">
                                                    {{ number_format($remainingQty, 3) }}
                                                </td>
                                                <td>{{ $returnedPieces }}</td>
                                                <td class="text-end">
                                                    @if($item->goodsStocks && $item->goodsStocks->isNotEmpty())
                                                        <a href="{{ route('inward.challan.reportsview', $challan->id) }}" class="btn-view" title="View Report">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @endif
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
            "searchPlaceholder": "Search records...",
            "paginate": {
                "next": "<i class='bi bi-chevron-right'></i>",
                "previous": "<i class='bi bi-chevron-left'></i>"
            }
        }
    });

     // Filter by Company (Frontend visual filter)
     $('#companyFilter').on('change', function() {
        var selectedText = $(this).find("option:selected").text();
        if($(this).val() === "") {
             table.column(2).search('').draw(); // Column 2 is Client Company
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

    var url = "{{ route('inward.challan.export') }}?company_id=" + companyId;
    
    if (onlySelected) {
         url += "&selected_ids=" + selectedIds.join(',');
    }

    window.location.href = url;
}
</script>
@endpush