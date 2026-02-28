@extends('layout-inward.app')

@section('title', 'Manage Companies')

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
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Add Button */
    .btn-gold {
        background-color: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.85rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
    }
    .btn-gold:hover {
        background-color: #d97706;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px -2px rgba(245, 158, 11, 0.3);
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

    /* Action Buttons */
    .btn-action-group {
        display: flex;
        gap: 6px;
    }
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
    }
    .btn-edit { color: #d97706; background: #fffbeb; border-color: #fcd34d; }
    .btn-edit:hover { background: #f59e0b; color: white; border-color: #f59e0b; }

    .btn-delete { color: #ef4444; background: #fef2f2; border-color: #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }

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
                        <a href="{{ route('inward.challan.create') }}" class="sidebar-link">
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
                        <a href="{{ route('companies.create') }}" class="sidebar-link active">
                            <i class="bi bi-building"></i>
                            <span>Create Client Company</span>
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
                                <h4 class="page-title">Manage Companies</h4>
                                <span class="text-muted small">View and manage client companies</span>
                            </div>
                            <div>
                                <a href="{{ route('companies.create') }}" class="btn-gold">
                                    <i class="bi bi-plus-lg"></i> New Company
                                </a>
                                <button type="button" class="btn-gold" data-bs-toggle="modal" data-bs-target="#importModal" style="margin-left: 10px;">
                                    <i class="bi bi-upload"></i> Import CSV
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Client Name</th>
                                        <th>Client Number</th>
                                        <th>Client GST Number</th>
                                        <th style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($companies as $company)
                                    <tr>
                                        <td class="text-secondary">{{ $i++ }}</td>
                                        <td class="fw-bold text-dark">{{ $company->industry_name }}</td>
                                        <td>{{ $company->industry_number }}</td>
                                        <td>{{ $company->industry_gstin }}</td>
                                        <td>
                                            <div class="btn-action-group">
                                                <a href="{{ route('inward.companies.edit', ['id' => $company->id]) }}" class="btn-icon btn-edit" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-delete" title="Delete">
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
</div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Companies</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('companies.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="file" class="form-label">Upload CSV File</label>
                <input class="form-control" type="file" id="file" name="file" required accept=".csv">
                <div class="form-text">Format: Name, Phone, GST, Address (Header row required)</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
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
            "searchPlaceholder": "Search companies...",
            "paginate": {
                "next": "<i class='bi bi-chevron-right'></i>",
                "previous": "<i class='bi bi-chevron-left'></i>"
            }
        }
    });
});
</script>
@endpush
