@extends('layout-inward.app')
@section('title', 'SUBSIDIARY CHALLAN')
@section('content')
<div class="common__section">
    <div class="container-fluid">
        <div class="divided__common__body">
            @include('layout-inward.sidebar')
            <div class="common__body">
                <h4 class="text-center" id="mobile_text">SUBSIDIARY CHALLAN</h4>
                <p class="text-center" id="mobile_text">
                    For movement of goods from processors to manufacturer / another processor in placement under Rule 55 of the CGST Rules, 2017
                </p>

                <!-- <table class="table table-bordered">
                   <tr>
                       <td><strong>Challan No:</strong></td>
                       <td>{{ $challan->challan_number }}</td>
                       <td><strong>Date:</strong></td>
                       
                        @php
                            $firstItem = $challan->inwarditems->first();
                            $firstGoodsStock = $firstItem?->goodsStocks->first();
                        @endphp

                        @if($firstGoodsStock)
                            <td class="text-end">
                                <strong>{{ $firstGoodsStock->created_at->format('d-m-Y') }}</strong> 
                            </td>
                        @endif
                   </tr>
               </table> -->


                <div class="border p-3">
                    <table class="table table-bordered">
    <tr>
        <td colspan="4">
            <strong>a. Name and Address of Processor:</strong><br>
            <strong>Name : </strong>{!! nl2br(e($challan->user->name)) !!}<br>
            <strong>Address : </strong>{!! nl2br(e($challan->user->address)) !!}<br>
            <strong>GSTIN:</strong> {{ $challan->user->gstin }}
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <strong>b. Name and Address of Manufacturer / Another person:</strong><br>
            <strong>Name : </strong>{!! nl2br(e($challan->company->industry_name)) !!}<br>
            <strong>Address : </strong>{!! nl2br(e($challan->company->industry_address)) !!}<br>
            <strong>GSTIN:</strong> {{ $challan->company->industry_gstin }}
        </td>
    </tr>
</table>


                    
<table class="table table-bordered">
    <tr>
        <td><strong>Main Challan No:</strong> {{ $challan->main_challan_number }}</td>
        <td class="text-end"><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</td>
    </tr>
</table>


                    <div class="pt-3">
                        <strong>2. Quantity Despatched:</strong>
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Item Name</th>
                                    <th>Kgs</th>
                                    <th>Pcs</th>
                                    <th>Remaining Kgs</th>
                                    <th>Date</th>
                                    <th>Challan No</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($challan->preparedItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->kgs }}</td>
                                        <td>{{ $item->pcs }}</td>
                                        <td>{{ $item->remaining_qty }}</td> <!-- Correct field for Remaining Kgs -->
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td> <!-- New Date Column -->
                                         <td>{{ $item->challan_number ?? '' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2" class="text-end">Total</th>
                                    <th>{{ $challan->preparedItems->sum('kgs') }}</th>
                                    <th>{{ $challan->preparedItems->sum('pcs') }}</th>
                                    <th>{{ $challan->preparedItems->pluck('remaining_qty')->last() }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <table class="table table-bordered">
                         <tr>
                             <td width="45%"><strong>3. Nature of Process:</strong></td>
                             <td width="55%">{{ $challan->purpose->name }}</td>
                             
                         </tr>
                     </table>

                     <table class="table table-bordered">
                         <tr>
                             <td width="45%"><strong>4. Quantity Left in Balance:</strong></td>
                             <td width="55%"> {{ $remainingStock ?? 'KG' }}</td>
                             
                         </tr>
                     </table>

                     <table class="table table-bordered">
                         <tr>
                             <td width="45%">
                                 <div><strong>Place:</strong> JAMNAGAR</div>
                                 <div><strong>Date:</strong> {{ $challan->date->format('d-m-Y') }}</div>
                             </td>
                             <td width="55%" class="text-end">
                                 <div style="height: 100px;"></div> {{-- Empty space for stamp/sign --}}
                                 <div><strong>Signature of Processor</strong></div>
                             </td>
                         </tr>
                     </table>


                  
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('inward.challan.print', $challan->id) }}" class="btn btn-primary me-3">
                        <i class="material-symbols-outlined">print</i> Print
                    </a>
                    <a href="{{ route('inward.challan.download', $challan->id) }}" class="btn btn-success">
                        <i class="material-symbols-outlined">download</i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
