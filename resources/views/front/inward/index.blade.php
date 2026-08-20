@extends('layout-inward.app')

@section('title', 'Manage Challans')

@section('content')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/css">
    /* General Typography & Core Colors */
    :root {
        --primary-dark: #0f172a;
        --accent-indigo: #6366f1;
        --accent-purple: #a855f7;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --glass-bg: rgba(255, 255, 255, 0.95);
        --neon-blue: #38bdf8;
        --border-color: #e2e8f0;
    }

    body, h1, h2, h3, h4, h5, table {
        font-family: 'Inter', sans-serif !important;
    }

    /* Page Header */
    .page-title {
        font-weight: 800;
        color: var(--primary-dark);
        font-size: 1.75rem;
        letter-spacing: -0.03em;
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

    /* Unboxed Table Wrapper */
    .premium-table-wrapper {
        background: transparent !important;
        backdrop-filter: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        width: 100% !important;
    }

    table.dataTable {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100% !important;
        margin-top: 0.5rem !important;
        border: none !important;
    }

    /* Header Styling */
    table.dataTable thead th {
        background: transparent !important;
        color: var(--text-muted) !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.1em;
        padding: 12px 1rem !important;
        border: none !important;
    }

    /* Body Styling */
    table.dataTable tbody tr {
        background: #fff !important;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    table.dataTable tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        background-color: #fff !important;
    }

    table.dataTable tbody td {
        padding: 1.25rem 1rem !important;
        vertical-align: middle !important;
        color: var(--text-main) !important;
        font-size: 0.9rem;
        border: none !important;
        border-top: 1px solid #f1f5f9 !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    table.dataTable tbody td:first-child {
        border-left: 1px solid #f1f5f9 !important;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    
    table.dataTable tbody td:last-child {
        border-right: 1px solid #f1f5f9 !important;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        transition: all 0.2s;
        margin-right: 8px;
        border: none;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-edit { background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); }
    .btn-items { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); }
    .btn-delete { background: linear-gradient(135deg, #f87171 0%, #dc2626 100%); }

    /* Remaining Qty Badges */
    .badge-remaining-active {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
    }
    .badge-remaining-zero {
        background-color: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
    }

    /* Top Action Buttons */
    .premium-btn-group .btn {
        height: 44px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 0 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }

    .btn-create-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
        text-decoration: none;
    }

    .btn-create-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(15, 23, 42, 0.4);
        color: white;
    }

    .btn-bulk-import {
        background: white;
        color: var(--primary-dark);
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-bulk-import:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }
    
    /* MODAL ENHANCEMENT */
    #importExcelModal .modal-dialog {
        max-width: 550px !important;
        margin: 1.75rem auto !important;
    }
    #importExcelModal .modal-content {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        border-radius: 20px !important;
        background: #fff !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2) !important;
        border: none !important;
        overflow: hidden !important;
    }
    #importExcelModal .modal-header {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
        padding: 1.5rem !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    #importExcelModal .modal-body {
        display: block !important;
        width: 100% !important;
        padding: 2.5rem 1.5rem !important;
    }
    #importExcelModal .modal-footer {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 0.75rem !important;
        width: 100% !important;
        padding: 1.5rem !important;
        background: #f8fafc !important;
        border-top: 1px solid #f1f5f9 !important;
    }
    #importExcelModal .modal-title {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    #importExcelModal .sample-card {
        background: #fffbeb !important;
        border: 1px solid #fde68a !important;
        border-radius: 12px !important;
        padding: 1.25rem !important;
        margin-bottom: 2rem !important;
        text-align: center !important;
        box-sizing: border-box !important;
    }
    /* Summary Metrics Bar */
    .summary-metrics-bar {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .metric-chip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 220px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .metric-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
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
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
</style>

<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         @include('layout-inward.sidebar')
         <div class="common__body flex-grow-1 min-vw-0">
             <section class="flight__onewaysectio p-0">
                   
                   <!-- Header Section -->
                   <div class="row align-items-center mb-4 mx-0">
                    <div class="col-md-6">
                       <h2 class="page-title">Manage Inward Challans</h2>
                       <p class="text-muted mb-0">Track and manage all your incoming material receipts.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="premium-btn-group d-flex justify-content-md-end gap-3 mt-3 mt-md-0">
                           <button type="button" class="btn btn-bulk-import" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                               <i class="bi bi-file-earmark-arrow-up-fill" style="color: #6366f1;"></i>
                               Bulk Import
                           </button>
                           <a href="{{ route('inward.challan.create') }}" class="btn btn-create-premium">
                               <i class="bi bi-plus-lg"></i>
                               Create New Inward
                           </a>
                        </div>
                    </div>
                 </div>

                    <!-- Modal for Excel Import -->
                    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true" style="padding-right: 0 !important;">
                       <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                                <div class="modal-header">
                                   <div class="modal-title" id="importExcelModalLabel">Import Inward Challans from Excel</div>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                       <i class="bi bi-x-lg"></i>
                                   </button>
                                </div>
                                <form action="{{ route('inward.challan.bulkImport') }}" method="POST" enctype="multipart/form-data" style="margin: 0 !important; display: block !important; width: 100% !important;">
                                   @csrf
                                   <div class="modal-body">
                                      <div class="sample-card">
                                         <a href="{{ route('inward.challan.sampleDownload') }}" style="color: #0f172a; font-weight: 700; text-decoration: underline;">
                                            <i class="bi bi-download" style="margin-right: 8px;"></i> Download Sample CSV
                                         </a>
                                         <div style="color: #64748b; font-size: 0.85rem; margin-top: 8px;">Use this format to prepare your Excel file before uploading.</div>
                                      </div>
                                      <div style="margin-top: 20px;">
                                         <label for="excel_file" style="display: block; font-weight: 600; color: #334155; margin-bottom: 8px;">Select Excel/CSV File</label>
                                         <input type="file" name="excel_file" class="form-control" id="excel_file" accept=".xlsx, .xls, .csv" required style="width: 100%;">
                                      </div>
                                   </div>
                                   <div class="modal-footer">
                                      <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 8px;">Cancel</button>
                                      <button type="submit" class="btn btn-primary" style="background: #6366f1; border: none; color: #fff; font-weight: 600; padding: 8px 16px; border-radius: 8px;">Start Import</button>
                                   </div>
                                </form>
                          </div>
                       </div>
                    </div>
                    <!-- Summary Metrics Bar -->
                    @php
                        $grandReceivedKgs = 0;
                        $grandReturnedKgs = 0;
                        $grandReceivedPcs = 0;
                        $grandReturnedPcs = 0;
                        foreach($challans as $ch) {
                            $cReceived = $ch->inwarditems->sum('qty');
                            if ($cReceived == 0 && $ch->total_qty > 0) {
                                $cReceived = $ch->total_qty;
                            }
                            $grandReceivedKgs += $cReceived;
                            $grandReceivedPcs += $ch->inwarditems->sum('piece_no');
                            foreach($ch->inwarditems as $iItem) {
                                $grandReturnedKgs += $iItem->goodsStocks->sum('kgs');
                                $grandReturnedPcs += $iItem->goodsStocks->sum('pcs');
                            }
                        }
                    @endphp
                    <div class="summary-metrics-bar">
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#e0f2fe; color:#0284c7;">
                                <i class="bi bi-files"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Inward Challans</div>
                                <div class="metric-value">{{ count($challans) }}</div>
                            </div>
                        </div>
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#ecfdf5; color:#059669;">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Received</div>
                                <div class="metric-value">{{ number_format($grandReceivedKgs, 3) }} kg <span class="fs-6 fw-normal text-muted">({{ $grandReceivedPcs }} Pcs)</span></div>
                            </div>
                        </div>
                        <div class="metric-chip">
                            <div class="metric-icon-box" style="background:#fef3c7; color:#d97706;">
                                <i class="bi bi-arrow-return-left"></i>
                            </div>
                            <div>
                                <div class="metric-title">Total Returned</div>
                                <div class="metric-value">{{ number_format($grandReturnedKgs, 3) }} kg <span class="fs-6 fw-normal text-muted">({{ $grandReturnedPcs }} Pcs)</span></div>
                            </div>
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
                                            <th>Client Name</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Total Qty (kg)</th>
                                            <th>Total Pcs</th>
                                            <th>Returned Pcs</th>
                                            <th>Remaining Qty (kg)</th>
                                            <th>Remaining Pcs</th>
                                            <th width="150">Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                        @foreach($challans as $key => $challan)
                                        @php
                                            $totalSentKgs = $challan->inwarditems->sum('qty');
                                            if ($totalSentKgs == 0 && $challan->total_qty > 0) {
                                                $totalSentKgs = $challan->total_qty;
                                            }
                                            $totalSentPcs = $challan->inwarditems->sum('piece_no');

                                            $totalReturnedKgs = 0;
                                            $totalReturnedPcs = 0;
                                            foreach ($challan->inwarditems as $inwardItem) {
                                                $totalReturnedKgs += $inwardItem->goodsStocks->sum('kgs');
                                                $totalReturnedPcs += $inwardItem->goodsStocks->sum('pcs');
                                            }
                                            $remainingKgs = max(0, $totalSentKgs - $totalReturnedKgs);
                                            $remainingPcs = max(0, $totalSentPcs - $totalReturnedPcs);
                                            $clientName = $challan->industry_name ?? optional($challan->company)->industry_name ?? 'N/A';
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-center">{{ ++$key }}</td>
                                            <td class="fw-medium text-dark">{{ $challan->main_challan_number }}</td>
                                            <td class="fw-semibold text-dark">{{ $clientName }}</td>
                                            <td>{{ date('d M, Y', strtotime($challan->date)) }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ optional($challan->purpose)->name }}</span>
                                            </td>
                                            <td class="fw-bold">{{ number_format($totalSentKgs, 3) }}</td>
                                            <td class="fw-semibold">{{ $totalSentPcs }}</td>
                                            <td class="{{ $totalReturnedPcs > 0 ? 'text-success fw-bold' : 'text-muted' }}">{{ $totalReturnedPcs }}</td>
                                            <td>
                                                @if($remainingKgs <= 0.001)
                                                    <span class="badge-remaining-zero">0.000 KG</span>
                                                @else
                                                    <span class="badge-remaining-active">{{ number_format($remainingKgs, 3) }} KG</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($remainingPcs <= 0)
                                                    <span class="badge-remaining-zero">0 Pcs</span>
                                                @else
                                                    <span class="badge-remaining-active">{{ $remainingPcs }} Pcs</span>
                                                @endif
                                            </td>
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
