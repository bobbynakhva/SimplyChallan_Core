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

    <div class="container" id="challan">
        <div class="text-center" style="padding:5px;"><b>DELIVERY CHALLAN FOR JOBWORK</b></div>
        <div class="text-center">Under Rule 55 of the Central Goods and Service Tax Rules, 2017.</div>
            <div class="text-center">Original Copy</div>
        <table>
        <tr>
                <td colspan="2">
                    <div>Name of the Consignor:</div>  <br>
                    <div>Address:</div> <br>
                    <div>GSTIN No.:</div>
                </td>
                <td colspan="4">
                    <h3>{{ strtoupper($challan->user->name) }}</h3>
                    <div>{{ $challan->user->address }}</div><br>
                    <div>{{ $challan->user->gstin }}</div>
                </td>
                <td >
                    <div>CHALLAN SR. NO: {{ $challan->challan_number }}  </div> 
                   
                    <div><br>
                    <br>CHALLAN DATE:  {{ \Carbon\Carbon::parse($challan->date)->format('d.m.Y') }}</div>
                </td>
            </tr>
        </table>
        <h4 class="heading">PART - I</h4>
        
        <table border="1" width="100%" cellspacing="0">
           
            <thead>
                <tr>
                    <th>Description of Inputs/Partially Processed Inputs</th>
                    <th>HSN Code</th>
                    <th>Price (Kgs)</th>
                    <th>Quantity (Kgs)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount = 0;
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
                    @endphp
                @endforeach
            </tbody>

        </table>
        <table border="1" width="100%" cellpadding="6" cellspacing="0">
                  <colgroup>
                       <col style="width: 1%;">   <!-- First column narrow -->
                       <col style="width: 45%;">  <!-- Second column -->
                       <col style="width: 55%;">  <!-- Third column (fills the rest) -->
                   </colgroup>
                    <tr>
                        <th>1.</th>
                        <th>Vehicle No.</th>
                        <td class="text-center">{{ $challan->vehicle_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>2.</th>
                        <th>No of Packages</th>
                        <td class="text-center">{{ $challan->no_of_packages }}</td>
                    </tr>
                    <tr>
                        <th>3.</th>
                        <th>Value of Inputs/Partially Processed Goods</th>
                        <td class="text-center">{{ $challan->grand_total }}</td>
                    </tr>
                    <tr>
    <th>4.</th>
    <th>Rate of Tax</th>
    <td class="text-center">
        CGST @ {{ intval($challan->cgst) }}% &nbsp;&nbsp;&nbsp;
        SGST @ {{ intval($challan->sgst) }}% &nbsp;&nbsp;&nbsp;
        Total Tax:
    </td>
</tr>
<tr>
    <th>5.</th>
    <th>Tax Amount</th>
    <td class="text-center">
        <strong>{{ number_format(($amount * $challan->cgst) / 100, 2) }}</strong> &nbsp;&nbsp;
        <strong>{{ number_format(($amount * $challan->sgst) / 100, 2) }}</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>{{ number_format($challan->total_tax, 2) }}</strong>
    </td>
</tr>

                    <tr>
                     <th>6.</th>
                        <th>Purpose</th>
                        <td class="text-center">{{ $challan->purpose }}</td>
                    </tr>
                    <tr>
                     <th>7.</th>
                        <th>Name of the Jobworker</th>
                        <td class="text-center">{{ $challan->industry_name }}</td>
                    </tr>
                    <tr>
                     <th>8.</th>
                        <th>Address of the Jobworker</th>
                        <td class="text-center">{{ $challan->industry_address }}</td>
                    </tr>
                    <tr>
                     <th>9.</th>
                        <th>GSTIN No. of Jobworker</th>
                        <td class="text-center">{{ $challan->industry_gstin }}</td>
                    </tr>
        </table>
        <table>
        <tr>
            <td colspan="2">
                <p>Place: JAMNAGAR &nbsp;&nbsp;  STATE: GUJARAT &nbsp;&nbsp; STATE CODE: 24</p>
                <p>Date: 17.02.2025</p>
            </td>
            <td>
               
                    <p><strong>FOR, <span style="text-transform: uppercase;">&nbsp;&nbsp;{{ $challan->industry_name }}</span></strong></p>
                    <p style="color: red; font-weight: bold;"></p><br><br><br>
                    <p><strong>ATHO. SIGN:</strong></p>
                
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
            <p></p>
        </tr>
        <tr >
            <th >3.</th>
            <th>Waste Scrap Returned</th>
            <td ></td>
             <p></p>
        </tr>
        <tr>
            <th >4.</th>
            <th>Waste & Scrap Not Recoverable</th>
            <td ></td>
             <p></p>
        </tr>
    </table>
<table><hr>
<tr >
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
</tr>
</table>
    </div>

</body>
</html>
