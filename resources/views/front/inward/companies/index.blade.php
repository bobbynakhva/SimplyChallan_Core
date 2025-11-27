@extends('layout-inward.app')

@section('title', 'Manage Company')

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
         @include('layout-inward.sidebar')
         <div class="common__body">
             <section class="flight__onewaysectio pt__60 pb__60">
                <div class="container">
                   <div class="row justify-content-between align-items-center mb-3">
                      <div class="col-md-6">
                         <h3 class="mb-0" id="mobile_text">Manage Company</h3>
                      </div>
                      <div class="col-md-6 text-end" id="mobile_text">
                         <a href="{{ route('companies.create') }}" class="btn btn-dark"><i class="bi bi-plus"></i></a>
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
                                         	<th>No</th>
                                            <th>Client Name</th>
                                            <th>Client Number</th>
                                            <th>Client GST Number</th>
                                            <th>Actions</th>
                                         </tr>
                                     </thead>
                                    <tbody class="align-middle">
									    @php $i = 1; @endphp  {{-- Initialize counter --}}
									    @foreach($companies as $company)
									    <tr>
									        <td>{{ $i++ }}</td>  {{-- Auto-increment number --}}
                                   <td>{{ $company->industry_name }}</td>
                                   <td>{{ $company->industry_number }}</td>
                                   <td>{{ $company->industry_gstin }}</td>
									        <td>
									            <a href="{{ route('inward.companies.edit', ['id' => $company->id]) }}" class="btn btn-primary">Edit</a>
                                       <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-danger">Delete</button>
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
    });
</script>
@endpush
