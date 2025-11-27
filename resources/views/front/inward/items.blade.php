@extends('layout-inward.app')
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
         @include('layout-inward.sidebar')
         <div class="common__body">
             <section class="flight__onewaysectio pt__60 pb__60">
                <div class="container">
                   <div class="row justify-content-between align-items-center mb-3">
                      <div class="col-md-6">
                         <h4 id="mobile_text">Manage Inward Challan Items</h4>
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
            <th>Total Qty (Kgs)</th>
            <th>Quantity Used (Kgs)</th>
            <th>Pieces</th> 
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @foreach($challan->inwarditems as $key => $item)
            @php
                $totalReturned = max(0, $item->goodsStocks->sum('kgs'));
                $remainingQty = max(0, $item->qty - $totalReturned);

                $remainingpiece = max(0, $item->piece_no - $item->goodsStocks->sum('pcs'));

                $status = ($remainingQty <= 0) ? 'Completed' : 'Pending';

               $lastStock = $item->goodsStocks->sortByDesc('id')->first();

            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ number_format($item->qty, 3) }}</td>
                <td>{{ number_format($totalReturned, 3) ?? '-' }}</td>
                <td>{{ $remainingpiece ?? '-' }}</td> <!-- New Data -->
                <td>
                    @if($status == 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td>
                   @if($lastStock)
                       <!-- Show PDF button for last stock entry -->
                       <a href="{{ route('inward.challan.invoice', $lastStock->id) }}" target="_blank" class="btn btn-success">
                           <i class="bi bi-printer"></i>
                       </a>
                   @endif
                    @if($item->qty > 0)
                    <a href="#updateReturnModal-{{ $item->id }}" class="btn btn-warning popup-content"><i class="bi bi-box-seam"></i></a>
                    @endif
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

@foreach($challan->inwarditems as $key => $item)
<div id="updateReturnModal-{{ $item->id }}" class="white-popup mfp-hide">
   <div class="signup__boxes p-3">
        <h5 class="fw-bold mb-4">
            Return Prepared Items - {{ $item->item_name }}<br>
            <small class="text-muted">Total Goods: <strong>{{ $item->qty }} KG</strong></small>
        </h5>
      <form method="POST" action="{{ route('inward.return-items.store') }}">
         @csrf
         <input type="hidden" name="inward_challan_items_id" value="{{ $item->id }}">
            <div class="row g-3">
                <div id="return-items-container-{{ $item->id }}">
                <div class="row g-3 return-item-row p-2">
                    <div class="col-lg-4">
                        <label for="item_name" class="form-label form--label">Item Name</label>
                        <input type="text" class="form--control @error('item_name') is-invalid @enderror"
                            id="item_name" name="items[0][item_name]" value="{{ $item->item_name }}"
                            placeholder="Enter Item Name">
                        @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                <!-- Quantity Returned -->
                <div class="col-lg-3">
                <label for="kgs" class="form-label form--label">Quantity (KG)</label>
                <input type="number" class="form--control @error('kgs') is-invalid @enderror"
                    id="kgs" name="items[0][kgs]"
                    placeholder="Enter Quantity">
                @error('kgs')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>

                <!-- Pieces Returned (New Field) -->
                <div class="col-lg-3">
                <label for="pcs" class="form-label form--label">Pieces (Pcs)</label>
                <input type="number" class="form--control @error('pcs') is-invalid @enderror"
                    id="pcs" name="items[0][pcs]"
                    placeholder="Enter Pieces Returned">
                @error('pcs')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>

                <div class="col-lg-2 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-dark add-more-btn" data-item-id="{{ $item->id }}">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                </div>
                </div>
                <!-- Buttons -->
                <div class="col-lg-12 text-center mt-3">
                <button type="submit" class="cmn__btn">
                    <span>Save</span>
                </button>
                <button type="button" class="cmn__btn close-mfp" >
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
$(document).on('click', '.close-mfp', function () {
        $.magnificPopup.close();
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
   document.querySelectorAll('.add-more-btn').forEach(button => {
      button.addEventListener('click', function () {
         const itemId = this.getAttribute('data-item-id');
         const container = document.getElementById(`return-items-container-${itemId}`);
         const rowCount = container.querySelectorAll('.return-item-row').length;
         
         const newRow = document.createElement('div');
         newRow.classList.add('row', 'g-3', 'p-2','return-item-row');
         newRow.innerHTML = `
            <div class="col-lg-4">
               <input type="text" name="items[${rowCount}][item_name]" class="form--control" placeholder="Enter Item Name">
            </div>
            <div class="col-lg-3">
               <input type="number" name="items[${rowCount}][kgs]" class="form--control" placeholder="KGs">
            </div>
            <div class="col-lg-3">
               <input type="number" name="items[${rowCount}][pcs]" class="form--control" placeholder="Pcs">
            </div>
            <div class="col-lg-2 mb-3 d-flex align-items-end">
               <button type="button" class="btn btn-danger remove-row-btn"><i class="bi bi-trash"></i></button>
            </div>
         `;

         container.appendChild(newRow);
      });
   });

   document.addEventListener('click', function (e) {
      if (e.target.closest('.remove-row-btn')) {
         e.target.closest('.return-item-row').remove();
      }
   });
});
</script>

@endpush
