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
                         <h3 class="mb-0" id="mobile_text">Manage Report Challan</h3>
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
            <th>Challan No.</th> <!-- New Column -->
            <th>Item Name</th>
            <th>Total Qty Sent (kg)</th>
            <th>Quantity Returned (kg)</th>
            <th>Balance</th>
            <th>Pieces Received Total</th> <!-- New Column -->
            <th>Despatch Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @php
        $ii = 0;
        @endphp
        @foreach($challans as $challan)
            @foreach($challan->items as $key => $item)
                @php
                    // Sum values from the related return_items table
                    $ii++;
                    $totalReturned = max(0, $item->returns->sum('quantity_returned'));
                    $remainingQty = max(0, $item->total_qty - $totalReturned);

                    $wasteScrapReturned = max(0, $item->returns->sum('waste_scrap_returned'));
                    $wasteNotRecoverable = max(0, $item->returns->sum('waste_not_recoverable'));

                    $remainingpiece = max(0,$item->returns->sum('piece_returned'));

                    $status = ($remainingQty <= 0) ? 'Completed' : 'Pending';
                @endphp
                <tr>
                    <td>{{ $ii }}</td>
                    <td>{{ strtoupper($challan->industry_name) }}</td>
                    <td>{{ $challan->challan_number ?? '-' }}</td> <!-- New Data -->
                    <td>{{ $item->item_name }}</td>
                    <td>{{ number_format($item->total_qty, 3) }}</td>
                    <td>{{ number_format($totalReturned, 3) ?? '-' }}</td>
                    <td>{{ number_format($remainingQty, 3) ?? '-' }}</td>
                    <td>{{ $remainingpiece ?? '-' }}</td> <!-- New Data -->
                    
                    <td>
                        {{ optional($item->returns->first())->despatch_date 
                            ? \Carbon\Carbon::parse($item->returns->first()->despatch_date)->format('d/m/Y') 
                            : '-' }}
                    </td>
                    <td>
                        @if($status == 'Completed')
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('challan.returnreportsview', $challan->id) }}" class="btn btn-warning"><i class="bi bi-pencil"> </i> </a>
                         <a href="{{ route('challan.reportsview', $challan->id) }}" class="btn btn-info"><i class="bi bi-eye"> </i></a>
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
