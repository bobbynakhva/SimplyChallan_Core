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
            display: none; /* Initially hidden */
            page-break-after: always;
        }
        /*.challan-copy {
            border: 2px solid #000;
            padding: 18px;
            margin-bottom: 30px;
            display: none;
        }*/
        .text-center {
            text-align: center;
            padding: 0px;
        }
        .bordered {
            border: 1px solid #000;
            padding: 9px;
        }
    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
        }
        .heading {
            margin-block-start: 0.6em;
            margin-block-end: 0.6em;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .sub-heading {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .space {
            height: 20px;
        }
        /*.break-page {
            page-break-after: always;
        }*/
        .btn-container {
            text-align: center;
            margin-bottom: 18px;
        }
        p {
            display: block;
            margin-block-start: 0.1em;
            margin-block-end: 0.1em;
        }

        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn-print { background-color: #17a2b8; color: white; }

        /* Hide buttons when printing */
        @media print {
            .btn-container {
                display: none;
            }
        }
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

    <div class="container" id="challan-{{ $key }}">
        <div class="text-center" style="padding:5px;"><b>DELIVERY CHALLAN FOR JOBWORK</b></div>
        <div class="text-center">Under Rule 55 of the Central Goods and Service Tax Rules, 2017.</div>
            <div class="text-center">{{ $copyType }} Copy</div>
        <table>
            <tr>
                <td colspan="2" style="border-bottom: none;">
                    <p>Name of the Consignor:</p>
                </td>
                <td colspan="4" style="border-bottom: none;">
                    <h3 style="margin: 0;"><b>{{ strtoupper($challan->user->name) }}</b></h3>
                </td>
                <td rowspan="3">
                    <p>CHALLAN SR. NO: {{ $challan->challan_number }}</p> 
                    <p>CHALLAN DATE:  {{ \Carbon\Carbon::parse($challan->date)->format('d.m.Y') }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none;">
                    <p>Address:</p>
                </td>
                <td colspan="4" style="border-top: none; border-bottom: none;">
                    <p><b>{{ $challan->user->address }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none;">
                    <p>GSTIN No.:</p>
                </td>
                <td colspan="4" style="border-top: none;">
                    <p><b>{{ $challan->user->gstin }}</b></p>
                </td>
            </tr>
        </table>
        <h4 class="heading">PART - I</h4>
        
        <table border="1" width="100%" cellspacing="0">
           
            <thead>
                <tr>
                    <th>1. Description of Inputs/Partially Processed Inputs</th>
                    <th>HSN Code</th>
                    <th>Price (Kgs)</th>
                    <th>Quantity (Kgs)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount = 0;
                    $totalQty = 0;
                @endphp
                @foreach($challan->items as $item)
                    <tr>
                        <td class="text-center">{{ $item->item_name }}</td>
                        <td class="text-center">{{ $item->hsn_code }}</td>
                        <td class="text-center">{{ $item->price_per_kg }}</td>
                        <td class="text-center">{{ $item->total_qty }}</td>
                    </tr>
                    @php
                        $amount += $item->total_value; // Correct way to accumulate total amount
                        $totalQty += $item->total_qty;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-left bold" style="text-align: left;">2. Quantity in kgs</td>
                    <td class="text-center bold">{{ $totalQty }}</td>
                </tr>
            </tfoot>

        </table>
        <table border="1" width="100%" cellpadding="6" cellspacing="0">
                  <colgroup>
                       <col style="width: 1%;">   <!-- First column narrow -->
                       <col style="width: 45%;">  <!-- Second column -->
                       <col style="width: 55%;">  <!-- Third column (fills the rest) -->
                   </colgroup>
                    <tr>
                        <th>3.</th>
                        <th>Vehicle No.</th>
                        <td class="text-center">{{ $challan->vehicle_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>4.</th>
                        <th>No of Packages</th>
                        <td class="text-center">{{ $challan->no_of_packages }}</td>
                    </tr>
                    <tr>
                        <th>5.</th>
                        <th>Value of Inputs/Partially Processed Goods</th>
                        <td class="text-center">{{ $challan->grand_total }}</td>
                    </tr>
                    <tr>
    <th>6.</th>
    <th>Rate of Tax</th>
    <td class="text-center">
        CGST @ {{ intval($challan->cgst) }}% &nbsp;&nbsp;&nbsp;
        SGST @ {{ intval($challan->sgst) }}% &nbsp;&nbsp;&nbsp;
        Total Tax:
    </td>
</tr>
<tr>
    <th>7.</th>
    <th>Tax Amount</th>
    <td class="text-center">
        <strong>{{ number_format(($amount * $challan->cgst) / 100, 2) }}</strong> &nbsp;&nbsp;
        <strong>{{ number_format(($amount * $challan->sgst) / 100, 2) }}</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>{{ number_format($challan->total_tax, 2) }}</strong>
    </td>
</tr>

                    <tr>
                     <th>8.</th>
                        <th>Purpose</th>
                        <td class="text-center">{{ $challan->purpose->name }}</td>
                    </tr>
                    <tr>
                     <th>9.</th>
                        <th>Name of the Jobworker</th>
                        <td class="text-center"><b>{{ $challan->industry_name }}</b></td>
                    </tr>
                    <tr>
                     <th>10.</th>
                        <th>Address of the Jobworker</th>
                        <td class="text-center"><b>{{ $challan->industry_address }}</b></td>
                    </tr>
                    <tr>
                     <th>11.</th>
                        <th>GSTIN No. of Jobworker</th>
                        <td class="text-center"><b>{{ $challan->industry_gstin }}</b></td>
                    </tr>
        </table>
        <table>
        <tr>
            <td colspan="1" width="60%">
                <div>Place: JAMNAGAR &nbsp; STATE: GUJARAT &nbsp; STATE CODE: 24</div>
                <div>Date: {{ \Carbon\Carbon::now()->format('d.m.Y') }}</div>
            </td>
            <td width="40%">
               
                    <div>&nbsp;<strong>FOR, <span style="text-transform: uppercase;">&nbsp;{{ strtoupper($challan->user->name) }}</span></strong></div>
                    <div style="color: red; font-weight: bold;"></div><br><br><br>
                    <div><strong>AUTH. SIGN:</strong></div>
                
            </td>
        </tr>
        </table>
  
    <h4 class="heading">PART - II</h4>
    <table>
        <tr  >
            <th width="1%">1.</th>
            <th width="31%">Date of despatch of finished goods to parents factory</th>
            <th width="30%"></th>
            <th width="38%">NAME AND ADDRESS STAMP OF <br> JOBWORKER </th>
        </tr>
        <tr >
            <th >2.</th>
            <th>Quantity Returned</th>
            <td ></td>
            <td rowspan="3" style="border: 1px solid black; vertical-align: top;"></td>
        </tr>
        <tr >
            <th >3.</th>
            <th>Waste Scrap Returned</th>
            <td ></td>
        </tr>
        <tr>
            <th >4.</th>
            <th>Waste & Scrap Not Recoverable</th>
            <td ></td>
        </tr>
    </table>
<table>
<tr >
    <div>
        <span>&nbsp;&nbsp;PLACE: JAMNAGAR,</span> <br>
        <span>&nbsp;&nbsp;STATE: GUJARAT,</span> <br>
        <span>&nbsp;&nbsp;STATE CODE: 24</span> <br>
        <span>&nbsp;&nbsp;DATE: </span> <br>
    </div>
    <div style="text-align: right;">
        <strong>AUTHORISED SIGNATORY : _____________</strong>
    </div>
</tr>
</table>
<!-- 

<hr>

<div style="display: flex; justify-content: space-between;">
    <div>
        <strong>FOR, {{ $challan->company->name }}</strong> <br>
        <span>PLACE: JAMNAGAR,</span> <br>
        <span>STATE: GUJARAT,</span> <br>
        <span>STATE CODE: 24</span> <br>
        <span>DATE: {{ \Carbon\Carbon::parse($challan->date)->format('d.m.Y') }}</span> <br>
    </div>
    <div style="text-align: right;">
        <strong>AUTHORISED SIGNATORY : _____________</strong>
    </div>
</div> -->

    </div>
@endforeach

<script>
    function printChallan(type) {
        // Hide all challan copies
        document.querySelectorAll('.container').forEach(el => el.style.display = 'none');

        // Show only the selected challan
        document.getElementById('challan-' + type).style.display = 'block';

        // Print the selected challan
        window.print();

        // Restore visibility after printing (optional, or reload page)
        /*setTimeout(() => {
             document.querySelectorAll('.container').forEach(el => el.style.display = 'block'); // Or keep hidden
        }, 1000);*/
    }

    function printAll() {
        // Show all challan copies
        document.querySelectorAll('.container').forEach(el => el.style.display = 'block');
        
        // Print
        window.print();
    }
</script>

</body>
</html>
