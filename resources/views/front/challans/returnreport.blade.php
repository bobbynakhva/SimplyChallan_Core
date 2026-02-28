@extends('layout.app')

@section('title', 'Return Report')

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
        padding: 40px;
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

    /* Info Sections */
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 600;
    }
    .info-box {
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        height: 100%;
    }

    /* Table Styling (Gold Theme) */
    .table-container {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .table-title {
        background-color: #fef3c7;
        color: #92400e;
        padding: 12px 20px;
        font-weight: 700;
        border-bottom: 1px solid #fcd34d;
        font-size: 1rem;
    }
    .gold-table {
        width: 100%;
        margin: 0;
    }
    .gold-table thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #f1f5f9;
    }
    .gold-table tbody td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        font-size: 0.85rem;
        color: #334155;
    }
    .gold-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .badge-status {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-info { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }

    /* Summary Table */
    .summary-table th {
        width: 40%;
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
    }
    .summary-table td {
        font-weight: 700;
        color: #0f172a;
        text-align: right;
    }
    .grand-total-row {
        background-color: #f0fdf4 !important;
    }
    .grand-total-row td {
        color: #166534;
        font-size: 1.1rem;
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
            <div class="common__body">
                <div class="container">
                    <div class="challan-card">
                        
                        <!-- Header -->
                        <div class="page-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="page-title">Challan Return Report</h4>
                                <span class="text-muted small">Detailed view of challan #{{ $challan->challan_number }}</span>
                            </div>
                            <div>
                                <a href="{{ route('challan.export_return_report', $challan->id) }}" class="btn btn-sm btn-success me-2">
                                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                                </a>
                                <a href="{{ route('challan.reports') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Reports
                                </a>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="info-label">Company</div>
                                            <div class="info-value">{{ $challan->industry_name }}</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="info-label">Industry Address</div>
                                            <div class="info-value text-muted small" style="font-weight: 400;">
                                                {{ $challan->industry_address }}<br>
                                                GSTIN: {{ $challan->industry_gstin }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="info-label">Date</div>
                                            <div class="info-value">{{ \Carbon\Carbon::parse($challan->date)->format('d M, Y') }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-label">Purpose</div>
                                            <div class="info-value">{{ $challan->purpose->name }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-label">Vehicle No</div>
                                            <div class="info-value">{{ $challan->vehicle_no ?? '-' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-label">Packages</div>
                                            <div class="info-value">{{ $challan->no_of_packages ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item Details Table -->
                        <div class="table-container">
                            <div class="table-title">
                                <i class="bi bi-box-seam me-2"></i> Item Details
                            </div>
                            <div class="table-responsive">
                                <table class="table gold-table">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>HSN Code</th>
                                            <th>Price (₹)</th>
                                            <th>Total Qty (Kg)</th>
                                            <th>Pending Qty (Kg)</th>
                                            <th>Total Value (₹)</th>
                                            <th>Piece No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($challan->items as $item)
                                        <tr>
                                        <tr>
                                            <td class="fw-bold">{{ $item->item_name }}</td>
                                            <td>{{ $item->hsn_code }}</td>
                                            <td>{{ number_format($item->price_per_kg, 2) }}</td>
                                            <td>{{ number_format($item->total_qty, 3) }}</td>
                                            <td>
                                                @php
                                                    $returned = $item->returns->sum('quantity_returned');
                                                    $scrap = $item->returns->sum('waste_scrap_returned');
                                                    $waste = $item->returns->sum('waste_not_recoverable');
                                                    $pending = max(0, $item->total_qty - ($returned + $scrap + $waste));
                                                @endphp
                                                <span class="{{ $pending > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                                    {{ number_format($pending, 3) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($item->total_value, 2) }}</td>
                                            <td>{{ $item->piece_no }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Return Details Table -->
                        <div class="table-container">
                            <div class="table-title" style="background-color: #e0f2fe; color: #0369a1; border-color: #bae6fd;">
                                <i class="bi bi-arrow-return-left me-2"></i> Return Transactions
                            </div>
                            <div class="table-responsive">
                                <table class="table gold-table">
                                    <thead>
                                        <tr>
                                            <th>Sub Challan</th>
                                            <th>Return Date</th>
                                            <th>Returned (Kg)</th>
                                            <th>Waste/Scrap (Kg)</th>
                                            <th>Unrecoverable (Kg)</th>
                                            <th>Pieces</th>
                                            <th width="20%">Notes</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($challan->returns as $return)
                                        <tr>
                                            <td>{{ $return->subsidiary_challan_number ?? '-' }}</td>
                                            <td>{{ $return->despatch_date ?? '-' }}</td>
                                            <td class="text-success fw-bold">{{ number_format($return->quantity_returned, 3) }}</td>
                                            <td>{{ number_format($return->waste_scrap_returned, 3) }}</td>
                                            <td>{{ number_format($return->waste_not_recoverable, 3) }}</td>
                                            <td>{{ $return->piece_returned }}</td>
                                            <td class="text-muted small">{{Str::limit($return->return_notes, 50)}}</td>
                                            <td>
                                                @if($return->status == 'returned')
                                                    <span class="badge-status badge-success">Returned</span>
                                                @elseif($return->status == 'pending')
                                                    <span class="badge-status badge-warning">Pending</span>
                                                @else
                                                    <span class="badge-status badge-info">Received</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No returns recorded yet.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Financial Summary -->
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="table-container">
                                    <table class="table gold-table summary-table mb-0">
                                        <tr>
                                            <th>CGST</th>
                                            <td>₹ {{ number_format($challan->cgst, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>SGST</th>
                                            <td>₹ {{ number_format($challan->sgst, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Tax</th>
                                            <td>₹ {{ number_format($challan->total_tax, 2) }}</td>
                                        </tr>
                                        <tr class="grand-total-row">
                                            <th>Grand Total</th>
                                            <td>₹ {{ number_format($challan->grand_total, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection