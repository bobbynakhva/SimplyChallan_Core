<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SUBSIDIARY CHALLAN</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .no-border td { border: none !important; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .pt-3 { padding-top: 12px; }
    </style>
</head>
<body>

    <h3 class="text-center">SUBSIDIARY CHALLAN</h3>
    <p class="text-center">
        For movement of goods from processors to manufacturer / another processor under Rule 55 of the CGST Rules, 2017
    </p>

    <table>
        <tr>
            <td><strong>Challan No:</strong></td>
            <td>{{ $challan->challan_number }}</td>
            <td><strong>Date:</strong></td>
            @php
                $firstItem = $challan->inwarditems->first();
                $firstGoodsStock = $firstItem?->goodsStocks->first();
            @endphp

            @if($firstGoodsStock)
                <td class="text-end">
                    <strong>{{ $firstGoodsStock->created_at->format('d-m-Y') }}</strong> 
                </td>
            @endif
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="4">
                <strong>a. Name and Address of Processor:</strong><br>
                <strong>{!! nl2br(e($challan->user->name)) !!}</strong> <br>
                 <strong>Plot No:</strong> {!! nl2br(e($challan->user->address)) !!}<br>
                <strong>GSTIN:</strong> {{ $challan->user->gstin }}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <strong>b. Name and Address of Manufacturer / Another person:</strong><br>
                <strong>{!! nl2br(e($challan->company->industry_name)) !!}</strong> <br>
                 <strong>Plot No:</strong>{!! nl2br(e($challan->company->industry_address)) !!}<br>
                <strong>GSTIN:</strong> {{ $challan->company->industry_gstin }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td><strong>1. Main Challan No:</strong> {{ $challan->main_challan_number }}</td>
            <td class="text-end"><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</td>
        </tr>
    </table>

    <strong>2. Quantity Despatched:</strong>
    <table>
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Pcs</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($challan->preparedItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->kgs }}</td>
                    <td>Kgs</td>
                    <td>{{ $item->pcs }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2" class="text-end">Total</th>
                <th>{{ $challan->preparedItems->sum('kgs') }}</th>
                <th>Kgs</th>
                <th>{{ $challan->preparedItems->sum('pcs') }}</th>
                <th></th>
            </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <td width="45%"><strong>3. Nature of Process:</strong></td>
            <td width="55%">{{ $challan->purpose->name }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="45%"><strong>4. Quantity Left in Balance:</strong></td>
            <td width="55%">{{ $remainingStock ?? '00' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="45%">
                <div><strong>Place:</strong> JAMNAGAR</div>
                <div><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</div>
            </td>
            <td width="55%" class="text-end">
                <div style="height: 100px;"></div>
                <div><strong>Signature of Processor</strong></div>
            </td>
        </tr>
    </table>

</body>
</html>
