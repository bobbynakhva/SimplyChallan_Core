@extends('layout-inward.app')
@section('title', 'Manage Challans')
@section('content')
<style type="text/css">
   @media (max-width: 768px) {
   #mobile_text {
   text-align: center !important;
   }
   }
   /* Add vertical lines between specific columns */
   #challanTable th, #challanTable td {
      border-right: 1.5px solid #333;
   }
   /* Remove right border from last column */
   #challanTable th:last-child, #challanTable td:last-child {
      border-right: none;
   }
</style>
<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         @include('layout-inward.sidebar')
         <div class="common__body">
            <section class="flight__onewaysectio pt__60 pb__60">
               <div class="container">
                  <div class="row justify-content-between align-items-center mb-3">
                     <div class="col-md-6">
                        <h4 class="" id="mobile_text">Manage Inward Report</h4>
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     <div class="col-xxl-12 col-xl-12 col-lg-12">
                        <div class="flight__oneway__wrapper">
                           <div class="flight__oneway__item mb__30">
                              <div class="flight__oneway__inner">
                                 <table class="table vertical-middle row-border" id="challanTable">
                                    <thead>
                                       <tr class="bgwhite circle__input">
                                          <th>#</th>
                                          <th>Client Company</th>
                                          <!-- <th>Inward Challan No.</th> -->
                                          <th>Main Challan No</th>
                                          <th>Item Name</th>
                                          <th>Total Qty</th>
                                          <th>Remaining Qty</th>
                                          <th>Pieces Total</th>
                                          <!-- New Column -->
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                       @php
                                       $ii = 0;
                                       @endphp
                                       @foreach($challans as $challan)
                                       @foreach($challan->inwarditems as $key => $item)
                                       @php

                                       $totalReturned = max(0, $item->goodsStocks->sum('kgs'));
                                       $remainingQty = max(0, $item->qty - $totalReturned);
                                       $remainingpiece = max(0, $item->piece_no - $item->goodsStocks->sum('pcs'));

                                       // Sum values from the related return_items table
                                       $ii++;
                                       @endphp
                                       <tr>
                                          <td>{{ $ii }}</td>
                                          <td>{{ strtoupper($challan->industry_name) }}</td>
                                          <!-- <td>{{ $challan->challan_number ?? '-' }}</td> -->
                                          <td>{{ $challan->main_challan_number }}</td>
                                          <!-- New Data -->
                                          <td>{{ $item->item_name }}</td>
                                          <td>{{ number_format($item->qty, 3) }}</td>
                                          <td>{{ number_format($remainingQty, 3) ?? '-' }}</td>
                                          <td>{{ $totalReturned ?? '-' }}</td>
                                          <!-- New Data -->
                                          <td>
                                             @if($item->goodsStocks && $item->goodsStocks->isNotEmpty())
                                                  <a href="{{ route('inward.challan.reportsview', $challan->id) }}" class="btn btn-info">
                                                      <i class="bi bi-eye"></i>
                                                  </a>
                                             @endif
                                          </td>
                                       </tr>
                                       @endforeach
                                       @endforeach
                                    </tbody>
                                 </table>
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
@push('scripts')
<script>
   $(document).ready(function() {
       $('#challanTable').DataTable({
           "paging": true,
           "lengthChange": false,
           "searching": true,
           "ordering": true,
           "info": true,
           "autoWidth": false,
           "responsive": true
       });
   });
</script>
@endpush