@extends('layout-inward.app')

@section('title', 'Backup & Restore')

@section('content')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/css">
    /* General Typography & Core Colors */
    :root {
        --primary-dark: #0f172a;
        --accent-indigo: #6366f1;
        --accent-purple: #a855f7;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --glass-bg: rgba(255, 255, 255, 0.95);
        --neon-blue: #38bdf8;
        --border-color: #e2e8f0;
    }

    body, h1, h2, h3, h4, h5 {
        font-family: 'Inter', sans-serif !important;
        color: var(--text-main);
    }

    /* Page Header */
    .page-title {
        font-weight: 800;
        color: var(--primary-dark);
        font-size: 1.75rem;
        letter-spacing: -0.03em;
        margin-bottom: 0.5rem;
    }

    /* Premium Card Styling */
    .premium-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        padding: 2.5rem;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .premium-card:hover {
        transform: translateY(-5px);
    }

    /* Button Styles */
    .btn-backup {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: white;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
    }

    .btn-backup:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(15, 23, 42, 0.4);
        color: #fff;
    }

    .btn-restore {
        background: white;
        color: var(--primary-dark);
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-restore:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        color: var(--primary-dark);
    }

    /* Alert Styling */
    .alert {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        border: none;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background-color: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .form-label {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 12px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid var(--border-color);
    }

    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        border-color: var(--accent-indigo);
    }

    .info-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 1.5rem;
        color: #92400e;
    }
</style>

<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         @include('layout-inward.sidebar')
         <div class="common__body">
             <section class="pt__40 pb__60">
                <div class="container">
                    
                    <!-- Header Section -->
                    <div class="row align-items-center mb-5">
                       <div class="col-md-8">
                          <h2 class="page-title">Backup & Restore</h2>
                          <p class="text-muted mb-0">Secure your database by exporting it or restore from a previous point in time.</p>
                       </div>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm">
                            <i class="bi bi-check-circle-fill fz-20"></i> 
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info shadow-sm" style="background-color: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6;">
                            <i class="bi bi-info-circle-fill fz-20"></i> 
                            <div>{{ session('info') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill fz-20"></i> 
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <div class="row g-4">
                        <!-- System Update Section -->
                        <div class="col-md-12 mb-2">
                            <div class="premium-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 5px solid #6366f1;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #e0e7ff; display: flex; align-items: center; justify-content: center; color: #4338ca;">
                                            <i class="bi bi-cloud-arrow-down-fill fz-24"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1" style="font-weight: 700;">Check & Install System Updates</h4>
                                            <p class="text-muted mb-0" style="font-size: 0.9rem;">Pull the latest software updates and features directly from GitHub with a single click.</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('system.update') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn-backup" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); padding: 12px 24px;">
                                            <i class="bi bi-arrow-repeat fz-18"></i>
                                            Update System Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Export Section -->
                        <div class="col-md-6">
                            <div class="premium-card">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: var(--primary-dark);">
                                        <i class="bi bi-cloud-arrow-down fz-24"></i>
                                    </div>
                                    <h4 class="mb-0" style="font-weight: 700;">Export Backup</h4>
                                </div>
                                
                                <p class="text-muted mb-5" style="line-height: 1.6;">Create a digital safety net. This will generate a ZIP file containing all your inward/outward challans, company settings, and goods stock data.</p>
                                
                                <form action="{{ route('backup.export') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-backup w-100 justify-content-center">
                                        <i class="bi bi-cloud-download-fill fz-18"></i>
                                        Generate Data Backup
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Restore Section -->
                        <div class="col-md-6">
                            <div class="premium-card">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #ef4444;">
                                        <i class="bi bi-cloud-arrow-up fz-24"></i>
                                    </div>
                                    <h4 class="mb-0" style="font-weight: 700;">Restore Data</h4>
                                </div>

                                <p class="text-muted mb-4" style="line-height: 1.6;">Restore your system to a previous state. <span class="text-danger fw-700">Warning:</span> Restoring will delete all current records from the app.</p>
                                
                                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label">Upload Backup File (.zip or .json)</label>
                                        <input type="file" name="backup_file" class="form-control" accept=".zip,.json" required>
                                    </div>
                                    
                                    <button type="submit" class="btn-restore w-100 justify-content-center" onclick="return confirm('⚠️ CRITICAL WARNING: This action will PERMANENTLY over-write all your existing data with the data from this backup file. Do you want to continue?')">
                                        <i class="bi bi-arrow-counterclockwise fz-18"></i>
                                        Finalize Restore
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Help -->
                    <div class="info-box mt-5">
                        <div class="d-flex gap-3">
                            <i class="bi bi-shield-lock-fill fz-24"></i>
                            <div>
                                <h5 class="mb-2" style="font-weight: 700;">Manual Backup Advice</h5>
                                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">We recommend backing up your data weekly. The generated file is in a portable format, allowing you to move your data between devices running Simply Challan. Keep these files encrypted or in a password-protected folder.</p>
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
