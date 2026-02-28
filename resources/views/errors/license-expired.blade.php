<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Expired</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fef2f2; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; }
        .expired-card { max-width: 500px; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; border: 1px solid #fee2e2; }
        .icon { font-size: 60px; color: #dc2626; margin-bottom: 20px; }
        h1 { font-weight: 800; color: #991b1b; margin-bottom: 10px; }
        p { color: #4b5563; line-height: 1.6; }
        .date-badge { background: #fee2e2; color: #991b1b; padding: 5px 15px; border-radius: 50px; font-weight: 700; display: inline-block; margin-top: 15px; }
        .contact-btn { background-color: #dc2626; color: white; border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; margin-top: 30px; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>
    <div class="expired-card">
        <div class="icon">🚫</div>
        <h1>License Expired</h1>
        <p>Your 1-year annual subscription for this software has ended. Please renew your license to continue accessing your data.</p>
        <div class="date-badge">Expired on: {{ $expiry_date }}</div>
        <br>
        <a href="mailto:your-email@example.com" class="contact-btn">Renew Now</a>
    </div>
</body>
</html>
