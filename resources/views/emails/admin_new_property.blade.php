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

        .details {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
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
            <h2>New Property Listed</h2>
        </div>
        <div class="content">
            <p>Hi Admin,</p>
            <p>A new property has been listed on the platform. Here are the details:</p>

            <div class="details">
                <p><strong>Listed By:</strong> {{ $agent_name }}</p>
                <p><strong>Property Title:</strong> {{ $property_title }}</p>
                <p><strong>Location:</strong> {{ $property_location }}</p>
                <p><strong>Price (Inc. Fees):</strong> £{{ number_format($property_price, 2) }}</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ $property_url }}" class="btn">View Property Details</a>
            </div>

            <p style="margin-top: 30px;">
                Best Regards,<br>
                Property Sourcing Group System
            </p>
        </div>
    </div>
</body>

</html>