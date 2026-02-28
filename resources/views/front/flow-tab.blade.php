<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Flow - Simply Challan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Modern Login Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/modern-login.css') }}?v={{ time() }}">

    <style>
        /* Specific overrides for Flow Selection */
        .flow-options {
            display: gap;
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .flow-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border-radius: 16px;
            border: 2px solid rgba(99, 102, 241, 0.1);
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            min-width: 140px;
        }

        .flow-btn:hover {
            transform: translateY(-5px);
            background: #fff;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
            border-color: #6366f1;
        }

        .flow-btn i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: -webkit-linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .flow-btn span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
        }

        .company-info {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
            margin-top: 1rem;
        }

        .company-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            padding: 0.5rem 1rem;
            border-radius: 99px;
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0.25rem;
        }
    </style>
</head>
<body>

    <section id="modern-login-section">
        <div class="ml-card">
            <div class="ml-header">
                <h4 class="ml-title">Select Flow</h4>
                <p class="ml-subtitle">Choose Inward or Outward to proceed</p>
            </div>
            
            <form method="POST" action="{{ route('flow-tab.select') }}">
                @csrf
                
                <div class="flow-options">
                    <button type="submit" name="flow_type" value="inward" class="flow-btn">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Inward</span>
                    </button>
                    
                    <button type="submit" name="flow_type" value="outward" class="flow-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Outward</span>
                    </button>
                </div>

            </form>

            <div class="company-info">
                @if(isset($company))
                    <div class="company-badge">
                        <i class="fa-regular fa-building"></i> {{ $company->name }}
                    </div>
                @endif
                
                @if(isset($financial_year))
                    <div class="company-badge">
                        <i class="fa-regular fa-calendar"></i> {{ $financial_year->year }}
                    </div>
                @endif
            </div>
        </div>
    </section>

</body>
</html>