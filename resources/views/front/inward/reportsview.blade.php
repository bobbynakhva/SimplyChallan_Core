@extends('layout-inward.app')
@section('title', 'Inward- Outward Report')

@push('styles')
<style>
    .report-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 40px;
        border: 1px solid #e2e8f0;
        max-width: 1000px;
        margin: 20px auto;
    }
    .report-title {
        color: #0f172a;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2rem;
        text-align: center;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 20px;
    }
    .info-group {
        margin-bottom: 1.5rem;
    }
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
        display: block;
    }
    .info-value {
        font-size: 0.95rem;
        color: #334155;
        font-weight: 500;
    }
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 20px 0;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    .table-custom th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-custom td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.9rem;
    }
    .table-custom tr:last-child td {
        border-bottom: none;
    }
    .section-header {
        background-color: #f1f5f9;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 600;
        color: #334155;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .footer-section {
        margin-top: 40px;
        border-top: 2px solid #f1f5f9;
        padding-top: 20px;
    }
</style>
@endpush

@section('content')
<div class="common__section page-wrapper">
    <div class="container-fluid">
        <div class="divided__common__body">
            @include('layout-inward.sidebar')
            
            <div class="common__body">
                <div class="report-card">
                    <h4 class="report-title">Inward- Outward Report</h4>

                    <!-- Process & Manufacturer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <div class="mb-3">
                                    <span class="info-label">a. Name and Address of Processor</span>
                                    <div class="info-value fw-bold">{!! nl2br(e($challan->user->name)) !!}</div>
                                    <div class="info-value">{!! nl2br(e($challan->user->address)) !!}</div>
                                    <div class="mt-2 text-muted small"><strong>GSTIN:</strong> {{ $challan->user->gstin }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <span class="info-label">b. Name and Address of Manufacturer / Another person</span>
                                <div class="info-value fw-bold">{!! nl2br(e($challan->company->industry_name)) !!}</div>
                                <div class="info-value">{!! nl2br(e($challan->company->industry_address)) !!}</div>
                                <div class="mt-2 text-muted small"><strong>GSTIN:</strong> {{ $challan->company->industry_gstin }}</div>
                            </div>
                        </div>
                    </div>


                    <!-- Challan Meta -->
                    @php
                        $totalSentPcs = $challan->inwarditems->sum('piece_no');
                    @endphp
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded">
                        <div>
                            <div class="text-muted small">Main Challan No</div>
                            <div class="fw-bold fs-5">{{ $challan->main_challan_number }}</div>
                        </div>
                        <div class="text-center px-4 border-start">
                            <div class="text-muted small">Total Quantity</div>
                            <div class="fw-bold fs-5">{{ number_format($totalSentQty, 3) }}</div>
                        </div>
                         <div class="text-center px-4 border-start border-end">
                            <div class="text-muted small">Total Pieces</div>
                            <div class="fw-bold fs-5">{{ $totalSentPcs > 0 ? $totalSentPcs : '-' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Date</div>
                            <div class="fw-bold fs-5">{{ $challan->date->format('d-m-Y') }}</div>
                        </div>
                    </div>

                    <!-- Quantity Despatched Table -->
                    <div class="section-header">2. Quantity Despatched</div>
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Item Name</th>
                                    <th>Kgs</th>
                                    <th>Pcs</th>
                                    <th>Remaining Kgs</th>
                                    <th>Remaining Pcs</th>
                                    <th>Date</th>
                                    <th>Challan No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $usedPcs = [];
                                @endphp
                                @foreach ($challan->preparedItems as $index => $item)
                                    @php
                                        $itemId = $item->inward_challan_items_id;
                                        if (!isset($usedPcs[$itemId])) {
                                            $usedPcs[$itemId] = 0;
                                        }
                                        $usedPcs[$itemId] += $item->pcs;
                                        $originalPcs = $item->inwardChallanItem->piece_no ?? 0;
                                        $remainingPcsForRow = $originalPcs - $usedPcs[$itemId];
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $item->item_name }}</td>
                                        <td>{{ number_format($item->kgs, 3) }}</td>
                                        <td>{{ $item->pcs }}</td>
                                        <td class="{{ $item->remaining_qty > 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($item->remaining_qty, 3) }}
                                        </td>
                                        <td class="{{ $remainingPcsForRow > 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $remainingPcsForRow }}
                                        </td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->challan_number ?? '-' }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-light fw-bold">
                                    <td colspan="2" class="text-end">Total</td>
                                    <td>{{ number_format($challan->preparedItems->sum('kgs'), 3) }}</td>
                                    <td>{{ $challan->preparedItems->sum('pcs') }}</td>
                                    <td>{{ number_format($remainingStock, 3) }}</td> <!-- Used trusted variable -->
                                    <td>
                                        @php
                                            $totalInwardPcs = $challan->inwarditems->sum('piece_no');
                                            $totalOutwardPcs = $challan->preparedItems->sum('pcs');
                                            $totalRemainingPcs = $totalInwardPcs - $totalOutwardPcs;
                                        @endphp
                                        {{ $totalRemainingPcs > 0 ? $totalRemainingPcs : '-' }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Other Details -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="section-header mt-0">3. Nature of Process</div>
                                <div class="p-2 ps-3 info-value border-start border-4 border-warning">
                                    {{ $challan->purpose->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="section-header mt-0">4. Quantity Left in Balance</div>
                                <div class="p-2 ps-3 info-value border-start border-4 border-info">
                                    {{ $remainingStock ?? 'KG' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="footer-section row">
                        <div class="col-6">
                            <div class="mb-1"><strong>Place:</strong> JAMNAGAR</div>
                            <div><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</div>
                        </div>
                        <div class="col-6 text-end">
                            <div style="height: 60px;"></div>
                            <div class="border-top d-inline-block pt-2" style="min-width: 200px;">
                                <strong>Signature of Processor</strong>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4 mb-5">
                    <a href="{{ route('inward.challan.print', $challan->id) }}" class="btn btn-primary me-3 px-4 rounded-pill shadow-sm">
                        <i class="bi bi-printer me-2"></i> Print
                    </a>
                    <a href="{{ route('inward.challan.export_report', $challan->id) }}" class="btn btn-warning px-4 rounded-pill shadow-sm text-white">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export to Excel
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
