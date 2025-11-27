@extends('layout.app')

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
                         <h3 class="mb-0" id="mobile_text">Manage Challans</h3>
                      </div>
                      <div class="col-md-6 text-end" id="mobile_text"><!-- class="cmn__btn" -->
                         <a href="{{ route('challan.create') }}"  class="btn btn-dark"><span><i class="bi bi-plus"></i></span></a>
                      </div>
                   </div>
                   <div class="row justify-content-center">
                      <div class="col-xxl-12 col-xl-12 col-lg-12">
                         <div class="flight__oneway__wrapper">
                            <div class="flight__oneway__item mb__30">
                               <div class="flight__oneway__inner">
                                  <table class="table vertical-middle" id="challanTable">
                                     <thead>
                                         <tr class="bgwhite circle__input">
                                            <th>Challan No</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Grand Total (₹)</th>
                                            <th>Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody class="align-middle">
                                        @foreach($challans as $challan)
                                        <tr>
                                            <td>{{ $challan->challan_number }}</td>
                                            <td>{{ date('d/m/Y', strtotime($challan->date)) }}</td>
                                            <td>{{ optional($challan->purpose)->name }}</td>
                                            <td>{{ $challan->grand_total }}</td>
                                            <td>
                                                <a href="{{ route('challan.view', $challan->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('challan.items', $challan->id) }}" class="btn btn-warning"><i class="bi bi-box-seam"></i></a>
                                                <a href="{{ route('challan.edit', $challan->id) }}" class="btn btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('challan.softDelete', $challan->id) }}" method="POST" style="display:inline;">
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
