<!DOCTYPE html>
<html>

<head>
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
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            background-color: #1E4072;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            padding: 20px;
        }

        .match-box {
            background-color: #fff9e6;
            border-left: 5px solid #ffcc00;
            padding: 15px;
            margin: 20px 0;
        }

        .property-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #F95CA8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Property Match Found!</h2>
        </div>
        <div class="content">
            <p>Hello {{ $agent->name }},</p>
            <p>Our system has identified a new property that matches the profile of your investor:
                <strong>{{ $investor->name }}</strong>.</p>

            <div class="match-box">
                <strong>Match Criteria:</strong>
                <ul style="margin-bottom: 0;">
                    <li>Location: {{ $property->location }}</li>
                    <li>Investor Budget: {{ $investor->budget }}</li>
                    <li>Investor Interest: {{ $investor->investment_interest }}</li>
                </ul>
            </div>

            <div class="property-card">
                <h3 style="margin-top: 0; color: #1E4072;">{{ $property->headline }}</h3>
                <p><strong>Price:</strong> £{{ number_format($property->price, 2) }}</p>
                <p><strong>Investment Type:</strong> {{ ucfirst(str_replace('_', ' ', $property->investment_type)) }}
                </p>
                <p>{{ Str::limit(strip_tags($property->full_description), 100) }}</p>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('available-properties.show', $property->id) }}" class="btn">View Property</a>
                </div>
            </div>

            <p style="margin-top: 30px;">
                You may want to contact {{ $investor->name }} regarding this opportunity.
            </p>

            <p>
                Best Regards,<br>
                Property Sourcing Group System
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Property Sourcing Group. Automatic Match Notification.
        </div>
    </div>
</body>

</html>