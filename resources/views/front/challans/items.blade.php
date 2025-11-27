@extends('layout.app')

@section('title', 'Manage Challan Items')

@section('content')
<style type="text/css">
   @media (max-width: 768px) {
    #mobile_text {
        text-align: center !important;
    }
}
.white-popup {
  position: relative;
  background: #FFF;
  padding: 20px;
  width: auto;
  max-width: 600px;
  margin: 20px auto;
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
                  <a href="{{ route('dashboard') }}" class="active">
                     Manage Challan
                  </a>
               </li>
               <!-- <li class="common__sideitems">
                  <a href="{{ route('challan.inward') }}">
                     Inward Challan
                  </a>
               </li> -->
               <li class="common__sideitems">
                  <a href="{{ route('challan.reports') }}">
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
                         <h3 class="mb-0" id="mobile_text">Manage Challan Items</h3>
                      </div>
                     
                   </div>
                   <div class="row justify-content-center">
                      <div class="col-xxl-12 col-xl-12 col-lg-12">
                         <div class="flight__oneway__wrapper">
                            <div class="flight__oneway__item mb__30">
                               <div class="flight__oneway__inner">
                                  <table class="table vertical-middle" id="challanTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Total Qty Sent (kg)</th>
            <th>Quantity Returned (kg)</th>
            <th>Waste Scrap Returned (kg)</th>
            <th>Waste Not Recoverable (kg)</th>
            <th>Pieces</th> 
            <th>Despatch Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @foreach($challan->items as $key => $item)
            @php
                $totalReturned = max(0, $item->returns->sum('quantity_returned'));
                $remainingQty = max(0, $item->total_qty - $totalReturned);

                $wasteScrapReturned = max(0, $item->returns->sum('waste_scrap_returned'));
                $wasteNotRecoverable = max(0, $item->returns->sum('waste_not_recoverable'));

                $remainingpiece = max(0, $item->piece_no - $item->returns->sum('piece_returned'));

                $status = ($remainingQty <= 0) ? 'Completed' : 'Pending';
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ number_format($item->total_qty, 3) }}</td>
                <td>{{ number_format($totalReturned, 3) ?? '-' }}</td>
                <td>{{ number_format($wasteScrapReturned, 3) ?? '-' }}</td>
                <td>{{ number_format($wasteNotRecoverable, 3) ?? '-' }}</td>
                <td>{{ $remainingpiece ?? '-' }}</td> <!-- New Data -->
                
                <td>{{ optional($item->returns->first())->despatch_date ? \Carbon\Carbon::parse($item->returns->first()->despatch_date)->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($status == 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td>
                    <a href="#updateReturnModal-{{ $item->id }}" class="btn btn-warning popup-content">Return</a>
                </td>
            </tr>
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

@foreach($challan->items as $key => $item)
<div id="updateReturnModal-{{ $item->id }}" class="white-popup mfp-hide">
   <div class="signup__boxes p-4">
      <h5 class="text-center fw-bold mb-3">
         Return - {{ $item->item_name }} <br>
         <small class="text-muted">Total Goods: <strong>{{ $item->total_qty }} KG</strong></small>
      </h5>
      <form method="POST" action="{{ route('return-items.store') }}">
         @csrf
         <input type="hidden" name="challan_item_id" value="{{ $item->id }}">

         <div class="row g-3">
         

            <div class="col-lg-6">
               <label for="subsidiary_challan_number" class="form-label form--label">Subsidiary Challan No.:</label>
               <input type="text" class="form--control @error('subsidiary_challan_number') is-invalid @enderror"
                  id="subsidiary_challan_number" name="subsidiary_challan_number"
                  value="{{ old('subsidiary_challan_number', $item->subsidiary_challan_number) }}">
               @error('subsidiary_challan_number')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Date -->
            <div class="col-lg-6">
               <label for="despatch_date" class="form-label form--label">Date</label>
               <input type="date" class="form--control @error('despatch_date') is-invalid @enderror"
                  id="despatch_date" name="despatch_date"
                  value="{{ old('despatch_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
               @error('despatch_date')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Quantity Returned -->
            <div class="col-lg-6">
               <label for="quantity_returned" class="form-label form--label">Quantity Returned (KG)</label>
               <input type="number" class="form--control @error('quantity_returned') is-invalid @enderror"
                  id="quantity_returned" name="quantity_returned" 
                  value="{{ old('quantity_returned', $item->quantity_returned) }}"
                  placeholder="Enter Quantity">
               @error('quantity_returned')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Pieces Returned (New Field) -->
            <div class="col-lg-6">
               <label for="piece_returned" class="form-label form--label">Pieces Returned (Pcs)</label>
               <input type="number" class="form--control @error('piece_returned') is-invalid @enderror"
                  id="piece_returned" name="piece_returned"
                  value="{{ old('piece_returned', $item->piece_returned) }}"
                  placeholder="Enter Pieces Returned">
               @error('piece_returned')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Waste Scrap Returned -->
            <div class="col-lg-6">
               <label for="waste_scrap_returned" class="form-label form--label">Waste Scrap (KG)</label>
               <input type="number" class="form--control @error('waste_scrap_returned') is-invalid @enderror"
                  id="waste_scrap_returned" name="waste_scrap_returned"
                  value="{{ old('waste_scrap_returned', $item->waste_scrap_returned) }}"
                  placeholder="Enter Waste Scrap">
               @error('waste_scrap_returned')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Waste Not Recoverable -->
            <div class="col-lg-6">
               <label for="waste_not_recoverable" class="form-label form--label">Waste Not Recoverable (KG)</label>
               <input type="number" class="form--control @error('waste_not_recoverable') is-invalid @enderror"
                  id="waste_not_recoverable" name="waste_not_recoverable"
                  value="{{ old('waste_not_recoverable', $item->waste_not_recoverable) }}"
                  placeholder="Enter Waste Not Recoverable">
               @error('waste_not_recoverable')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>

            <!-- Notes -->
            <div class="col-lg-6">
               <div class="input__grp">
                  <label for="return_notes" class="form-label">Notes</label>
                  <textarea name="return_notes" id="return_notes" class="form--control"
                     rows="3" placeholder="Enter any additional notes">{{ old('return_notes', $item->return_notes) }}</textarea>
                  @error('return_notes')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
            </div>

            <!-- Buttons -->
            <div class="col-lg-12 text-center mt-3">
               <button type="submit" class="cmn__btn">
                  <span>Save</span>
               </button>
               <button type="button" class="cmn__btn" data-dismiss="modal">
                  <span>Cancel</span>
               </button>
            </div>
         </div>
      </form>
   </div>
</div>
@endforeach

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

    $('.popup-content').magnificPopup({
        type: 'inline',
        midClick: true
    });
});
</script>
@endpush
