<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Challan Return Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #fef3c7; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .success { color: #166534; }
        .danger { color: #dc2626; }
        .heading { font-size: 14px; font-weight: bold; background-color: #e0f2fe; }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="4" style="font-size: 16px; font-weight: bold; text-align: center;">Challan Return Report</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Challan #{{ $challan->challan_number }}</td>
        </tr>
        <tr><td colspan="4"></td></tr> <!-- Spacer -->

        <!-- Basic Info -->
        <tr>
            <th>Company</th>
            <td>{{ $challan->industry_name }}</td>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($challan->date)->format('d M, Y') }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $challan->industry_address }}</td>
            <th>Purpose</th>
            <td>{{ $challan->purpose->name }}</td>
        </tr>
        <tr>
            <th>GSTIN</th>
            <td>{{ $challan->industry_gstin }}</td>
            <th>Vehicle No</th>
            <td>{{ $challan->vehicle_no ?? '-' }}</td>
        </tr>
        <tr>
            <td></td><td></td>
            <th>Packages</th>
            <td>{{ $challan->no_of_packages ?? '-' }}</td>
        </tr>
        <tr><td colspan="4"></td></tr> <!-- Spacer -->
    </table>

    <!-- Item Details -->
    <table>
        <thead>
            <tr>
                <th colspan="7" class="heading">Item Details</th>
            </tr>
            <tr>
                <th>Item Name</th>
                <th>HSN Code</th>
                <th>Price (Rs)</th>
                <th>Total Qty (Kg)</th>
                <th>Pending Qty (Kg)</th>
                <th>Total Value (Rs)</th>
                <th>Piece No.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($challan->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
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
                    <span class="{{ $pending > 0 ? 'danger' : 'success' }}">
                        {{ number_format($pending, 3) }}
                    </span>
                </td>
                <td>{{ number_format($item->total_value, 2) }}</td>
                <td>{{ $item->piece_no }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <!-- Return Transactions -->
    <table>
        <thead>
            <tr>
                <th colspan="8" class="heading">Return Transactions</th>
            </tr>
            <tr>
                <th>Sub Challan</th>
                <th>Return Date</th>
                <th>Returned (Kg)</th>
                <th>Waste/Scrap (Kg)</th>
                <th>Unrecoverable (Kg)</th>
                <th>Pieces</th>
                <th>Notes</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($challan->returns as $return)
            <tr>
                <td>{{ $return->subsidiary_challan_number ?? '-' }}</td>
                <td>{{ $return->despatch_date ?? '-' }}</td>
                <td>{{ number_format($return->quantity_returned, 3) }}</td>
                <td>{{ number_format($return->waste_scrap_returned, 3) }}</td>
                <td>{{ number_format($return->waste_not_recoverable, 3) }}</td>
                <td>{{ $return->piece_returned }}</td>
                <td>{{ $return->return_notes }}</td>
                <td>{{ ucfirst($return->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No returns recorded yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <br>

    <!-- Financial Summary -->
    <table>
        <tr>
            <th colspan="2" class="heading">Financial Summary</th>
        </tr>
        <tr>
            <th>CGST</th>
            <td class="text-right">{{ number_format($challan->cgst, 2) }}</td>
        </tr>
        <tr>
            <th>SGST</th>
            <td class="text-right">{{ number_format($challan->sgst, 2) }}</td>
        </tr>
        <tr>
            <th>Total Tax</th>
            <td class="text-right">{{ number_format($challan->total_tax, 2) }}</td>
        </tr>
        <tr>
            <th style="background-color: #dcfce7;">Grand Total</th>
            <td class="text-right" style="font-weight: bold;">{{ number_format($challan->grand_total, 2) }}</td>
        </tr>
    </table>

</body>
</html>
