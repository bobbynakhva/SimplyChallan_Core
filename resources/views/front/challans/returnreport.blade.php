@extends('layout.app')

@section('title', 'Manage Challans')

@section('content')
<style type="text/css">
   @media (max-width: 768px) {
    #mobile_text {
        text-align: center !important;
    }
}
</style>
<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         <div class="side__sticky">
            <ul class="common__sidebar__wrapper">
                  <li class="common__sideitems">
                  <a href="{{ route('challan.create') }}">
                    New Challan
                  </a>
               </li>
                <li class="common__sideitems">
                  <a href="{{ route('dashboard') }}" >
                     Manage Challan
                  </a>
               </li>
             
               <!-- <li class="common__sideitems">
                  <a href="{{ route('challan.inward') }}" >
                     Inward Challan
                  </a>
               </li> -->
               <li class="common__sideitems">
                  <a href="{{ route('challan.reports') }}" class="active">
                     Reports
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('purposes.index') }}">
                  New Purpose
                  </a>
               </li>
           </ul>
         </div>

                                    <div class="common__body">
             <section class="flight__onewaysectio pt__60 pb__60">
                <div class="container">
                   <div class="row justify-content-between align-items-center mb-3">
                      <div class="col-md-6">
                         <h3 class="mb-0" id="mobile_text">Manage Inward Challan</h3>
                      </div>
                   </div>
                   <div class="row justify-content-center">
                      <div class="col-xxl-12 col-xl-12 col-lg-12">
                         <div class="flight__oneway__wrapper">
                            <div class="flight__oneway__item mb__30">
                               <div class="flight__oneway__inner">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h5><strong>Company Name:</strong> {{ $challan->company->name }}</h5>
                                                        <p><strong>Industry:</strong> {{ $challan->industry_name }}</p>
                                                        <p><strong>Industry GSTIN:</strong> {{ $challan->industry_gstin }}</p>
                                                        <p><strong>Industry Address:</strong> {{ $challan->industry_address }}</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <h5><strong>Date:</strong> {{ $challan->date }}</h5>
                                                        <p><strong>Purpose:</strong> {{ $challan->purpose->name }}</p>
                                                        <p><strong>Vehicle No:</strong> {{ $challan->vehicle_no }}</p>
                                                        <p><strong>No. of Packages:</strong> {{ $challan->no_of_packages }}</p>
                                                    </div>
                                                </div>

                                                <hr>

                                                <h5 class="text-center"><strong>Item Details</strong></h5>
                                                <table class="table table-bordered">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Sub Challan No</th>
                                                            <th>Item Name</th>
                                                            <th>HSN Code</th>
                                                            <th>Price per Kg (₹)</th>
                                                            <th>Total Qty (Kg)</th>
                                                            <th>Total Value (₹)</th>
                                                            <th>Piece No.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($challan->items as $item)
                                                        
                                                            <tr>
                                                                <td>{{ $item->subsidiary_challan_number }}</td>
                                                                <td>{{ $item->item_name }}</td>
                                                                <td>{{ $item->hsn_code }}</td>
                                                                <td>{{ number_format($item->price_per_kg, 2) }}</td>
                                                                <td>{{ number_format($item->total_qty, 2) }}</td>
                                                                <td>{{ number_format($item->total_value, 2) }}</td>
                                                                <td>{{ $item->piece_no }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <hr>

                                                <h5 class="text-center"><strong>Return Details</strong></h5>
                                                <table class="table table-bordered">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>Subsidiary Challan Number Date</th>
                                                            <th>Return Date</th>
                                                            <th>Returned Qty (Kg)</th>
                                                            <th>Waste/Scrap Returned (Kg)</th>
                                                            <th>Waste Not Recoverable (Kg)</th>
                                                            <th>Pieces Returned</th>
                                                            <th>Notes</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($challan->returns as $return)
                                                            <tr>
                                                                <td>{{ $return->subsidiary_challan_number ?? 'N/A' }}</td>
                                                                <td>{{ $return->despatch_date ?? 'N/A' }}</td>
                                                                <td>{{ number_format($return->quantity_returned, 2) }}</td>
                                                                <td>{{ number_format($return->waste_scrap_returned, 2) }}</td>
                                                                <td>{{ number_format($return->waste_not_recoverable, 2) }}</td>
                                                                <td>{{ number_format($return->piece_returned, 2) }}</td>
                                                                <td>{{ $return->return_notes }}</td>
                                                                <td>
                                                                    @if($return->status == 'returned')
                                                                        <span class="badge bg-success">Returned</span>
                                                                    @elseif($return->status == 'pending')
                                                                        <span class="badge bg-warning">Pending</span>
                                                                    @else
                                                                        <span class="badge bg-info">Received</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <hr>

                                                <h5 class="text-center"><strong>Financial Summary</strong></h5>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>CGST (₹)</th>
                                                        <td>{{ number_format($challan->cgst, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>SGST (₹)</th>
                                                        <td>{{ number_format($challan->sgst, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Tax (₹)</th>
                                                        <td>{{ number_format($challan->total_tax, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Grand Total (₹)</th>
                                                        <td><strong>{{ number_format($challan->grand_total, 2) }}</strong></td>
                                                    </tr>
                                                </table>

                                                
                                            </div>




                                        </div>
                                    </div>
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