<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset OTP</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f1f5f9; font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 40px 16px; color: #0f172a; }
        .wrap { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(15,23,42,.08); }
        .header { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 60%, #312e81 100%); padding: 36px 40px; }
        .header-inner { display: flex; align-items: center; gap: 12px; }
        .logo-badge { background: #ffffff; border-radius: 10px; padding: 8px 14px; display: inline-block; }
        .logo-badge span { font-size: 18px; font-weight: 800; color: #4f46e5; letter-spacing: -0.5px; }
        .header h2 { color: rgba(255,255,255,.85); font-size: 13px; font-weight: 500; margin-top: 16px; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 12px; }
        .msg { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 28px; }
        .otp-block { background: #f8fafc; border: 2px dashed #a5b4fc; border-radius: 12px; padding: 28px; text-align: center; margin-bottom: 28px; }
        .otp-label { font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: #94a3b8; margin-bottom: 10px; }
        .otp-code { font-size: 42px; font-weight: 800; letter-spacing: 10px; color: #4f46e5; line-height: 1; }
        .otp-expiry { margin-top: 10px; font-size: 12px; color: #94a3b8; }
        .note { font-size: 12px; color: #94a3b8; line-height: 1.6; padding: 16px; background: #fffbeb; border-left: 3px solid #f59e0b; border-radius: 6px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <div class="logo-badge"><span>IBO</span></div>
            <h2>Infinity Back Office · Password Reset</h2>
        </div>

        <div class="body">
            <p class="greeting">Hi {{ $name }},</p>
            <p class="msg">
                We received a request to reset the password for your account. Use the one-time code below to continue.
                If you did not request this, you can safely ignore this email — your account remains secure.
            </p>

            <div class="otp-block">
                <p class="otp-label">Your verification code</p>
                <p class="otp-code">{{ $otp }}</p>
                <p class="otp-expiry">Expires in <strong>10 minutes</strong></p>
            </div>

            <p class="note">
                For your security, never share this code with anyone. Infinity Back Office staff will never ask for your OTP.
            </p>
        </div>

        <div class="footer">
            <p>© Infinity Care · Perth · Victoria<br>This is an automated message, please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
