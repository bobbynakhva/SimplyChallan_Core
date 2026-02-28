@extends('layout.app')

@section('content')
<div class="common__section">
    <div class="container-fluid">
        <div class="common__body">
            <h2 class="cmn__title">License Management</h2>
            <p class="mb-3">Manage active license bindings and view machine information.</p>

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 15px;">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 20px;">
                        <h4 class="mb-4">System Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Current License Key (.env)</h6>
                                <div class="p-2 bg-light border rounded small font-family-monospace text-primary">
                                    {{ $currentKey ?: 'NONE' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6>Your Current Machine ID</h6>
                                <div class="p-2 bg-light border rounded small font-family-monospace">
                                    {{ $currentMachineId }}
                                </div>
                            </div>
                        </div>
                        
                        <p class="small text-muted mb-0">Note: License keys are hardware-bound. One key per PC.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 20px;">
                        <h4 class="mb-4">Active License Bindings</h4>
                        @if(empty($bindings))
                            <p class="text-muted">No license keys have been activated yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>License Key</th>
                                            <th>Machine ID</th>
                                            <th>Activated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bindings as $key => $data)
                                        <tr>
                                            <td style="font-family: monospace;">{{ $key }}</td>
                                            <td class="small text-muted" style="font-family: monospace;">{{ $data['machine_id'] }}</td>
                                            <td>{{ $data['activated_at'] }}</td>
                                            <td>
                                                <form action="{{ route('admin.license.reset') }}" method="POST" onsubmit="return confirm('Reset this license? The user will be able to activate it on a new machine.')">
                                                    @csrf
                                                    <input type="hidden" name="license_key" value="{{ $key }}">
                                                    <button type="submit" class="btn btn-sm btn-danger px-3" style="border-radius: 50px;">
                                                        Reset Binding
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
