@extends('layout-inward.app')

@section('title', 'Create Client Company')

@push('styles')
<style>
    /* === PROFESSIONAL THEME: GOLD & WHITE === */
    body, .page-wrapper {
        background-color: #f7f9fc !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        color: #1e293b;
    }

    /* GLOBAL FOCUS RESET */
    *:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    /* === SIDEBAR (Standardized) === */
    ul.common__sidebar__wrapper {
        background-color: #ffffff !important;
        border-radius: 12px;
        padding: 20px 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        min-height: calc(100vh - 100px);
        display: flex;
        flex-direction: column;
        gap: 8px;
        border: 1px solid #f1f5f9;
        margin-top: 50px;
    }
    
    .side__sticky {
        position: sticky;
        top: 110px !important;
        z-index: 99;
    }

    .common__sideitems {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .sidebar-link:hover {
        background-color: #f8fafc;
        color: #334155;
        transform: translateX(4px);
    }

    .sidebar-link.active {
        background-color: #f59e0b !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.25);
        font-weight: 600;
    }
    
    .sidebar-link i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    /* === MAIN CARD === */
    .challan-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Form Elements - Pill Style */
    .form-group label {
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control, .form-select {
        border-radius: 50px !important; /* Pill Shape */
        border: 1px solid #e2e8f0;
        padding: 12px 20px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s;
        background-color: #f8fafc;
        height: auto;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    textarea.form-control {
        border-radius: 20px !important;
    }

    /* Buttons */
    .btn-gold {
        background-color: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.25);
    }
    .btn-gold:hover {
        background-color: #d97706;
        color: white;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="common__section page-wrapper">
    <div class="container-fluid">
        <div class="divided__common__body">
            
            <!-- SIDEBAR -->
            <div class="side__sticky">
                <ul class="common__sidebar__wrapper">
                    <li class="common__sideitems">
                        <a href="{{ route('inward.challan.create') }}" class="sidebar-link">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>New Inward Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid"></i>
                            <span>Manage Inward Challan</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.challan.reports') }}" class="sidebar-link">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Inward Reports</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('inward.purposes.index') }}" class="sidebar-link">
                            <i class="bi bi-tag"></i>
                            <span>Manage Purposes</span>
                        </a>
                    </li>
                    <li class="common__sideitems">
                        <a href="{{ route('companies.create') }}" class="sidebar-link active">
                            <i class="bi bi-building"></i>
                            <span>Create Client Company</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="common__body">
                <div class="container">
                    
                    <form action="{{ route('companies.store') }}" method="POST">
                        @csrf
                        <div class="challan-card">
                            
                            <!-- Header -->
                            <div class="page-header">
                                <h4 class="page-title">Create Client Company</h4>
                                <div class="text-muted small">Add details for a new client company</div>
                            </div>

                            <!-- Form Grid -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6 form-group">
                                    <label>Client Name <span class="text-danger">*</span></label>
                                    <input type="text" name="industry_name" class="form-control" placeholder="Enter company name" value="{{ old('industry_name') }}" required>
                                    @error('industry_name')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Client Phone Number</label>
                                    <input type="text" name="industry_number" class="form-control" placeholder="Enter phone number" value="{{ old('industry_number') }}">
                                    @error('industry_number')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Client GST Number</label>
                                    <input type="text" name="industry_gstin" class="form-control" placeholder="e.g. 24AAAAA0000A1Z5" value="{{ old('industry_gstin') }}" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$" title="Please enter a valid GST number">
                                    @error('industry_gstin')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group">
                                    <label>Client Address</label>
                                    <textarea name="industry_address" class="form-control" rows="3" placeholder="Enter full address">{{ old('industry_address') }}</textarea>
                                    @error('industry_address')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn-gold">
                                    Create Client Company <i class="bi bi-check2-circle ms-2"></i>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection