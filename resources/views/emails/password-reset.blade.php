<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #1E4072 0%, #F95CA8 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .email-body {
            padding: 40px 30px;
            color: #0b1c33;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 20px 0;
            font-size: 16px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #F95CA8 0%, #F95CA8 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            margin: 25px 0;
            box-shadow: 0 4px 10px rgba(249, 92, 168, 0.3);
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(249, 92, 168, 0.4);
        }
        .info-box {
            background-color: rgba(76, 215, 246, 0.1);
            border-left: 4px solid #4CD7F6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #1E4072;
        }
        .warning-box {
            background-color: rgba(249, 92, 168, 0.1);
            border-left: 4px solid #F95CA8;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .warning-box p {
            margin: 0;
            font-size: 14px;
            color: #1E4072;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #6c757d;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #F95CA8;
            text-decoration: none;
            font-size: 20px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 20px;
                border-radius: 8px;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="{{ asset('logo.png') }}" alt="Property Sourcing Group">
            <h1>Reset Password</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Hello,</p>
            
            <p>You are receiving this email because we received a password reset request for your account.</p>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ $url }}" class="cta-button">Reset Password</a>
            </div>

            <!-- Expiry Info -->
            <div class="info-box">
                <p><strong>Note:</strong> This password reset link will expire in 60 minutes. Please reset your password as soon as possible.</p>
            </div>

            <!-- Warning -->
            <div class="warning-box">
                <p>If you did not request a password reset, no further action is required. Your account remains secure.</p>
            </div>

            <p>Need help? Contact our support team at <a href="mailto:info@propertysourcinggroup.co.uk" style="color: #F95CA8; text-decoration: none;">info@propertysourcinggroup.co.uk</a></p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="social-links">
                <a href="https://facebook.com/profile.php?id=61587416069479" target="_blank">&#xf082;</a>
                <a href="https://instagram.com/propertysourcinggroup" target="_blank">&#xf16d;</a>
                <a href="https://wa.me/+442034680480">&#xf232;</a>
            </div>
            <p><strong>Property Sourcing Group</strong></p>
            <p>5-7 High Street London United Kingdom. E 13 0AD</p>
            <p>+44 203 468 0480 | info@propertysourcinggroup.co.uk</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Property Sourcing Group is a trading style of Property Sales Direct Limited.<br>
                Company Number 17051593<br>
                Registered address: 57 Hallsville Rd, London, United Kingdom, E16 1EE
            </p>
            <p style="margin-top: 15px; font-size: 11px; color: #adb5bd;">
                &copy; {{ date('Y') }} Property Sourcing Group. All Rights Reserved.
            </p>
        </div>
    </div>
</body>
</html>
