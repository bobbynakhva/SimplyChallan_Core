<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Simply Challan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
    
    <!-- Modern Login Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/modern-login.css') }}?v={{ time() }}">
</head>
<body>

    <section id="modern-login-section">
        <div class="ml-card">
            <div class="ml-header">
                <h4 class="ml-title">Welcome Back</h4>
                <p class="ml-subtitle">Sign in to your account and manage your payments efficiently.</p>
            </div>
            
            <form action="{{ route('loginpost') }}" method="POST">
                @csrf
                
                <div class="ml-form-group">
                    <label for="email" class="ml-label">Email Address</label>
                    <input type="email" id="email" name="email" 
                           class="ml-input @error('email') is-invalid @enderror" 
                           placeholder="name@company.com" 
                           value="{{ old('email') }}" 
                           required autocomplete="email" autofocus>
                    @error('email')
                        <span class="bad-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="ml-form-group">
                    <label for="password" class="ml-label">Password</label>
                    <input type="password" id="password" name="password" 
                           class="ml-input @error('password') is-invalid @enderror" 
                           placeholder="Enter your password" 
                           required autocomplete="current-password">
                    @error('password')
                        <span class="bad-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                @if (Route::has('password.request'))
                    <div class="ml-actions">
                        <a href="{{ route('password.request') }}" class="ml-forgot">Forgot Password?</a>
                    </div>
                @endif

                <button type="submit" class="ml-btn">
                    Sign In
                </button>
            </form>
        </div>
    </section>

</body>
</html>