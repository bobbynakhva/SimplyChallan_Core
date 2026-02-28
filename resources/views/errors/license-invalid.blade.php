<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Required</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; }
        .license-card { max-width: 600px; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; }
        .icon { font-size: 50px; color: #dc3545; margin-bottom: 20px; }
        h1 { font-weight: 800; color: #1e293b; margin-bottom: 20px; }
        .machine-id-box { background: #f1f5f9; padding: 15px; border-radius: 10px; font-family: monospace; font-size: 14px; margin: 20px 0; border: 1px dashed #cbd5e1; color: #475569; word-break: break-all; }
        p { color: #64748b; }
        .instruction { font-size: 13px; color: #94a3b8; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="license-card">
        <div class="icon">🔒</div>
        <h1>Unauthorized Machine</h1>
        <p>This application is locked to a specific computer. It appears you have moved the files to a new machine or the license has not been activated for this hardware.</p>
        
        @if(isset($reason))
        <div class="alert alert-danger mt-3" style="border-radius: 10px;">
            <b>Issue:</b> {{ $reason }}
        </div>
        @endif

        <p class="mb-0 mt-4 font-weight-bold">Please provide this <b>Machine ID</b> to the developer:</p>
        <div class="machine-id-box">
            {{ $machine_id }}
        </div>

        <hr class="my-4">

        <h5 class="mb-3">Activate Application</h5>
        <form action="{{ route('license.activate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="license_key" class="form-control form-control-lg text-center" placeholder="Paste your License Key here" style="border-radius: 10px; font-family: monospace;" required>
            </div>
            <button type="submit" class="btn btn-dark w-100 btn-lg" style="border-radius: 50px;">
                Activate Now
            </button>
        </form>

        <p class="instruction">Your license key is hardware-bound and will work only on this computer.</p>
    </div>
</body>
</html>
