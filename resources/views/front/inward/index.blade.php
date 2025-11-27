@extends('layout-inward.app')

@section('title', 'Manage Challans')

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
                         <h4 id="mobile_text">Manage Inward Challans</h4>
                      </div>
                      <div class="col-md-6 text-end" id="mobile_text"><!-- class="cmn__btn" -->
                         <a href="{{ route('inward.challan.create') }}"  class="btn btn-dark"><span><i class="bi bi-plus"></i></span></a>
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
                                            <th>No</th>
                                            <th>Main Challan No</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Total Qty</th>
                                            <th>Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody class="align-middle">
                                        @foreach($challans as $key => $challan)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $challan->main_challan_number }}</td>
                                            <td>{{ date('d/m/Y', strtotime($challan->date)) }}</td>
                                            <td>{{ optional($challan->purpose)->name }}</td>
                                            <td>{{ $challan->total_qty }}</td>
                                            <td>
                                                <a href="{{ route('inward.challan.edit', $challan->id) }}" class="btn btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('inward.challan.items', $challan->id) }}" class="btn btn-warning"><i class="bi bi-box-seam"></i></a>
                                                <form action="{{ route('inward.challan.softDelete', $challan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this challan?');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
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
