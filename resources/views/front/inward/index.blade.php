@extends('layout-inward.app')

@section('title', 'Manage Challans')

@section('content')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/css">
    /* General Typography */
    body, h1, h2, h3, h4, h5, table {
        font-family: 'Inter', sans-serif !important;
    }

    /* Page Header */
    .page-title {
        font-weight: 700;
        color: #111827;
        font-size: 1.5rem;
        letter-spacing: -0.025em;
    }

    /* Premium Table Styling */
    .premium-table-wrapper {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        padding: 1rem;
    }

    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
        margin-top: 1rem !important;
    }

    /* Header Styling */
    table.dataTable thead th {
        background-color: #f9fafb !important;
        color: #374151 !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem !important;
        border-bottom: 2px solid #e5e7eb !important;
        border-top: 1px solid #e5e7eb !important;
    }

    /* Body Styling */
    table.dataTable tbody td {
        padding: 1rem !important;
        vertical-align: middle !important;
        color: #4b5563 !important;
        font-size: 0.875rem;
        border-bottom: 1px solid #e5e7eb !important;
        border-right: 1px solid #f3f4f6; /* Subtle vertical lines */
    }
    
    table.dataTable tbody td:last-child {
        border-right: none;
    }

    table.dataTable tbody tr:hover {
        background-color: #f9fafb !important;
    }

    /* "Lines in table" - ensure borders are visible */
    .table-bordered td, .table-bordered th {
        border: 1px solid #e5e7eb !important;
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        transition: all 0.2s;
        margin-right: 4px;
        border: none;
        color: white;
    }

    .btn-edit { background-color: #3b82f6; } /* Blue */
    .btn-edit:hover { background-color: #2563eb; }

    .btn-items { background-color: #f59e0b; } /* Amber */
    .btn-items:hover { background-color: #d97706; }

    .btn-delete { background-color: #ef4444; } /* Red */
    .btn-delete:hover { background-color: #dc2626; }

    /* Create Button */
    .btn-create-premium {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: transform 0.2s;
    }
    .btn-create-premium:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5);
    }
    
    @media (max-width: 768px) {
        #mobile_text { text-align: center !important; }
        .page-title { margin-bottom: 1rem; }
        .btn-create-premium { width: 100%; justify-content: center; }
    }
</style>

<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         @include('layout-inward.sidebar')
         <div class="common__body">
             <section class="flight__onewaysectio pt__40 pb__60">
                <div class="container">
                   
                   <!-- Header Section -->
                   <div class="row justify-content-between align-items-center mb-4">
                      <div class="col-md-6">
                         <h4 id="mobile_text" class="page-title">Manage Inward Challans</h4>
                      </div>
                      <div class="col-md-6 text-end" id="mobile_text">
                         <a href="{{ route('inward.challan.create') }}" class="btn-create-premium">
                            <i class="bi bi-plus-lg"></i>
                            <span>New Challan</span>
                         </a>
                      </div>
                   </div>

                   <div class="row justify-content-center">
                      <div class="col-xxl-12 col-xl-12 col-lg-12">
                         <div class="premium-table-wrapper">
                                  <table class="table table-bordered vertical-middle" id="challanTable">
                                     <thead>
                                         <tr>
                                            <th>No</th>
                                            <th>Main Challan No</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Total Qty</th>
                                            <th width="150">Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                        @foreach($challans as $key => $challan)
                                        <tr>
                                            <td class="fw-bold text-center">{{ ++$key }}</td>
                                            <td class="fw-medium text-dark">{{ $challan->main_challan_number }}</td>
                                            <td>{{ date('d M, Y', strtotime($challan->date)) }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ optional($challan->purpose)->name }}</span>
                                            </td>
                                            <td class="fw-bold">{{ $challan->total_qty }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('inward.challan.edit', $challan->id) }}" class="action-btn btn-edit" title="Edit">
                                                        <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                    <a href="{{ route('inward.challan.items', $challan->id) }}" class="action-btn btn-items" title="View Items">
                                                        <i class="bi bi-box-seam-fill" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                    <form action="{{ route('inward.challan.softDelete', $challan->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn btn-delete" onclick="return confirm('Are you sure?');" title="Delete">
                                                            <i class="bi bi-trash-fill" style="font-size: 0.8rem;"></i>
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
             </section>
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
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search records..."
        }
    });
});
</script>
@endpush
