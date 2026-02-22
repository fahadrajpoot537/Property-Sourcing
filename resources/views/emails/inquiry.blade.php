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
            <h2 style="margin: 0;">New {{ ucfirst($type) }} Inquiry</h2>
            <p style="margin: 10px 0 0; opacity: 0.9;">Property Sourcing Group</p>
        </div>

        <div class="content">
            <p style="font-size: 16px; margin-bottom: 25px;">You have received a new inquiry from your website.</p>

            <div class="field">
                <div class="field-label">Name:</div>
                <div class="field-value">{{ $name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
            </div>

            <div class="field">
                <div class="field-label">Phone:</div>
                <div class="field-value"><a href="tel:{{ $phone }}">{{ $phone }}</a></div>
            </div>

            @if($ready_to_buy)
                <div class="field">
                    <div class="field-label">Ready to Buy:</div>
                    <div class="field-value">{{ $ready_to_buy }}</div>
                </div>
            @endif

            @if(isset($investment_type) && $investment_type)
                <div class="field">
                    <div class="field-label">Investment Interests:</div>
                    <div class="field-value">{{ $investment_type }}</div>
                </div>
            @endif

            @if(isset($is_cash_buyer) && $is_cash_buyer)
                <div class="field">
                    <div class="field-label">Cash Buyer:</div>
                    <div class="field-value">{{ $is_cash_buyer }}</div>
                </div>
            @endif

            @if(isset($budget) && $budget)
                <div class="field">
                    <div class="field-label">Budget:</div>
                    <div class="field-value">{{ $budget }}</div>
                </div>
            @endif

            @if($experience_level)
                <div class="field">
                    <div class="field-label">Experience Level:</div>
                    <div class="field-value">{{ $experience_level }}</div>
                </div>
            @endif

            @if($comments)
                <div class="field">
                    <div class="field-label">Additional Comments:</div>
                    <div class="field-value">{{ $comments }}</div>
                </div>
            @endif

            @if($source_page)
                <div class="field">
                    <div class="field-label">Source Page:</div>
                    <div class="field-value">{{ $source_page }}</div>
                </div>
            @endif

            <div class="footer">
                <p>This email was sent from Property Sourcing Group website inquiry form.</p>
                <p>&copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>