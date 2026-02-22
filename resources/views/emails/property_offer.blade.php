<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #1E4072, #2a5a9e);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background: #f8f9fc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }

        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #F95CA8;
        }

        .field-label {
            font-weight: 600;
            color: #1E4072;
            margin-bottom: 5px;
        }

        .field-value {
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #F95CA8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">New Property Offer Received</h2>
            <p style="margin: 10px 0 0; opacity: 0.9;">Property Sourcing Group</p>
        </div>
        <div class="content">
            <p style="font-size: 16px; margin-bottom: 25px;">A new offer has been placed on a property.</p>

            <div class="field">
                <div class="field-label">Property:</div>
                <div class="field-value">{{ $property_title }}</div>
            </div>

            <div class="field">
                <div class="field-label">Location:</div>
                <div class="field-value">{{ $property_location }}</div>
            </div>

            <div class="field">
                <div class="field-label">Offer Amount:</div>
                <div class="field-value" style="font-size: 20px; font-weight: bold; color: #F95CA8;">
                    £{{ number_format($offer_amount, 2) }}</div>
            </div>

            <div class="field">
                <div class="field-label">Investor Name:</div>
                <div class="field-value">{{ $user_name }} ({{ $user_email }})</div>
            </div>

            @if($notes)
                <div class="field">
                    <div class="field-label">Investor Notes:</div>
                    <div class="field-value">{{ $notes }}</div>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ $offer_url }}" class="btn">View Offer in Admin Panel</a>
            </div>

            <div class="footer">
                <p>This is an automated notification from Property Sourcing Group.</p>
                <p>&copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>