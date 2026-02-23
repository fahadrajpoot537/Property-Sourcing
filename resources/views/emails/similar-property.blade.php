<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Matching Property Notification</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: #1E4072;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .content {
            padding: 30px;
        }

        .alert-badge {
            display: inline-block;
            background: #F95CA8;
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-uppercase: uppercase;
            margin-bottom: 15px;
        }

        .property-card {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .property-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .property-details {
            padding: 25px;
        }

        .property-headline {
            font-size: 20px;
            font-weight: 700;
            color: #1E4072;
            margin: 0 0 10px 0;
        }

        .property-meta {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .property-price {
            font-size: 24px;
            font-weight: 700;
            color: #F95CA8;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            background-color: #F95CA8;
            color: #fff !important;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            width: 80%;
            margin: 0 auto;
            display: block;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Matching Opportunity</h1>
        </div>
        <div class="content">
            <div class="alert-badge">Instant Notification</div>
            <p>Hi,</p>
            <p>We've just listed a new property that matches your previous inquiries. Based on your interest in similar
                properties in this area and budget range, we thought you'd want to be the first to know!</p>

            <div class="property-card">
                @if($property->thumbnail)
                    <img src="{{ Str::startsWith($property->thumbnail, 'http') ? $property->thumbnail : asset('storage/' . $property->thumbnail) }}"
                        class="property-img" alt="{{ $property->headline }}">
                @endif
                <div class="property-details">
                    <h2 class="property-headline">{{ $property->headline }}</h2>
                    <div class="property-meta">
                        <strong>Location:</strong> {{ $property->location }}<br>
                        <strong>Type:</strong> {{ $property->propertyType->name ?? 'Property' }} |
                        {{ $property->unitType->name ?? '' }}<br>
                        <strong>Configuration:</strong>
                        @if($property->bedrooms) {{ $property->bedrooms }} Bed @endif
                        @if($property->bathrooms) | {{ $property->bathrooms }} Bath @endif
                    </div>
                    <div class="property-price">
                        £{{ number_format($property->price, 0) }}
                    </div>
                    <a href="{{ url('/available-properties/' . $property->id) }}" class="btn">View Full Details &
                        Photos</a>
                </div>
            </div>

            <p style="margin-top: 25px;">This deal might get snapped up quickly. If you have any questions or want to
                schedule a viewing, please reply to this email or call us immediately.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.<br>
            inquiries@propertysourcinggroup.co.uk
        </div>
    </div>
</body>

</html>