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

        .property-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin: 20px 0;
        }

        .property-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .property-info {
            padding: 15px;
        }

        .price {
            color: #F95CA8;
            font-size: 20px;
            font-weight: bold;
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
            <h2>New Property Available</h2>
        </div>
        <div class="content">
            <p>Hi there,</p>
            <p>Agent <strong>{{ $agent->name }}</strong> has just listed a new property that might be of interest to
                your investors.</p>

            <div class="property-card">
                @if($property->thumbnail)
                    <img src="{{ $message->embed(public_path('storage/' . $property->thumbnail)) }}" class="property-img">
                @endif
                <div class="property-info">
                    <h3>{{ $property->headline }}</h3>
                    <p>{{ Str::limit(strip_tags($property->full_description), 150) }}</p>
                    <p class="price">£{{ number_format($property->price, 2) }}</p>
                    <p><strong>Location:</strong> {{ $property->location }}</p>
                    <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $property->investment_type)) }}</p>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('available-properties.show', $property->id) }}" class="btn">View Full Details</a>
            </div>

            <p style="margin-top: 30px;">
                Best Regards,<br>
                Property Sourcing Group
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.<br>
            Sent via <strong>{{ $agent->email }}</strong>
        </div>
    </div>
</body>

</html>