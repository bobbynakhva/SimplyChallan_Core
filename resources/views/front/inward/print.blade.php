<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challan Print</title>
    <style>
       body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: auto;
            border: 1px solid #000;
        }
        .text-center { text-align: center; padding: 0px; }
        .bordered { border: 1px solid #000; padding: 9px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #000; padding: 3px; text-align: left; }
        .text-end { text-align: right; }
        .btn-container { text-align: center; margin-bottom: 18px; }
        .btn { padding: 10px 20px; margin: 5px; border: none; cursor: pointer; font-size: 16px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn-print { background-color: #17a2b8; color: white; }

        /* Hide buttons when printing */
        @media print {
            .btn-container { display: none; }
            .page-break { page-break-after: always; }
        }

        /* Initially hide all challans */
        .challan-copy { display: none; }
    </style>
</head>
<body>

<!-- Buttons -->
<div class="btn-container">
    <button class="btn btn-primary" onclick="printChallan('original')">Print Original</button>
    <button class="btn btn-success" onclick="printChallan('duplicate')">Print Duplicate</button>
    <button class="btn btn-warning" onclick="printChallan('triplicate')">Print Triplicate</button>
    <button class="btn btn-print" onclick="printAll()">Print All</button>
</div>

<!-- Challan Copies -->
@foreach(['original' => 'Original', 'duplicate' => 'Duplicate', 'triplicate' => 'Triplicate'] as $key => $copyType)
    <div class="container challan-copy" id="challan-{{ $key }}">
        <div class="text-center" style="padding:5px;"><b>SUBSIDIARY CHALLAN</b></div>
        <div class="text-center">For movement of goods from processors to manufacturer / another processor under Rule 55 of the CGST Rules, 2017</div>
            <div class="text-center">{{ $copyType }} Copy</div>
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
    <table>
     <thead>
            <tr><td><strong>2. Quantity Despatched:</strong></td></tr>
    </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Pcs</th>
                <th>Date</th>
                <th>Challan No</th>
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
                    <td>{{ $item->created_at->format('d-m-Y') }}</td> <!-- New Date Column -->
                     <td>{{ $item->challan_number ?? '' }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2" class="text-end">Total</th>
                <th>{{ $challan->preparedItems->sum('kgs') }}</th>
                <th>Kgs</th>
                <th>{{ $challan->preparedItems->sum('pcs') }}</th>
                <th></th>
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
                <div><strong>Place:</strong> JAMNAGAR</div><br>
                <div><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</div>
            </td>
            <td width="55%" class="text-end">
                <div style="height: 100px;"></div>
                <div><strong>Signature of Processor</strong></div>
            </td>
        </tr>
    </table>
         <!-- Page Break -->
        <div class="page-break"></div>
    </div>
@endforeach

<script>
    function printChallan(type) {
        // Hide all challans
        document.querySelectorAll('.challan-copy').forEach(el => el.style.display = 'none');

        // Show selected challan
        document.getElementById('challan-' + type).style.display = 'block';

        // Print
        window.print();

        // Hide again after print
        setTimeout(() => {
            document.getElementById('challan-' + type).style.display = 'none';
        }, 1000);
    }

    function printAll() {
        // Show all challans for print
        document.querySelectorAll('.challan-copy').forEach(el => el.style.display = 'block');

        // Print
        window.print();

        // Hide all after print
        setTimeout(() => {
            document.querySelectorAll('.challan-copy').forEach(el => el.style.display = 'none');
        }, 1000);
    }
</script>

</body>
</html>
