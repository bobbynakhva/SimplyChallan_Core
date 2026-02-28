@extends('layout-inward.app')

@section('title', 'Manage Purpose')

@push('styles')
<style>
    /* Professional Theme - Gold & White/Grey */
    body, .page-wrapper {
        background-color: #f7f9fc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #1e293b;
    }

    /* === GLOBAL FOCUS RESET === */
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

    /* Primary Action Button (Add Purpose) */
    .btn-primary-gold {
        background-color: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
    }
    .btn-primary-gold:hover {
        background-color: #b45309;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px -2px rgba(245, 158, 11, 0.3);
    }
    .btn-primary-gold:active {
        transform: translateY(0);
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
        padding: 16px 20px;
        border-bottom: 2px solid #e2e8f0;
        border-top: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    #challanTable tbody td {
        background-color: #ffffff;
        color: #334155;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    /* Remove border from last column */
    #challanTable thead th:last-child,
    #challanTable tbody td:last-child {
        border-right: none;
    }
    #challanTable tbody tr:hover td {
        background-color: #fdfdfd;
    }

    /* Action Buttons in Table */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none;
        background: #f8fafc;
    }
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    /* Edit Button (Gold/Yellow) */
    .btn-edit {
        color: #d97706;
        background-color: #fffbeb;
        border: 1px solid #fcd34d;
    }
    .btn-edit:hover {
        background-color: #fcd34d !important; /* Force override for specificity */
        color: #92400e !important;
    }

    /* Delete Button (Red) */
    .btn-delete {
        color: #dc2626;
        background-color: #fef2f2;
        border: 1px solid #fecaca;
    }
    .btn-delete:hover {
        background-color: #fecaca !important;
        color: #991b1b !important;
    }
    .btn-delete-trigger {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex; /* Ensure icon centers */
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
                                <h4 class="page-title">Manage Purpose</h4>
                                <span class="text-muted small">Create and manage purpose categories</span>
                            </div>
                            <div>
                                <a href="{{ route('inward.purposes.create') }}" class="btn-primary-gold">
                                    <i class="bi bi-plus-lg"></i> Add Purpose
                                </a>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="table-responsive">
                            <table class="table" id="challanTable">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">#</th>
                                        <th>Purpose Name</th>
                                        <th class="text-end" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purposes as $key => $purpose)
                                    <tr>
                                        <td class="fw-bold text-muted">{{ $key + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $purpose->name }}</td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('inward.purposes.edit', $purpose->id) }}" class="btn-action btn-edit" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <form action="{{ route('inward.purposes.destroy', $purpose->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this purpose?')" title="Delete">
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
            "searchPlaceholder": "Search purposes...",
            "paginate": {
                "next": "<i class='bi bi-chevron-right'></i>",
                "previous": "<i class='bi bi-chevron-left'></i>"
            }
        }
    });
});
</script>
@endpush
