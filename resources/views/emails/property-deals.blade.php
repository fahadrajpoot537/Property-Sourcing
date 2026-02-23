<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $customSubject }}</title>
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

        .property-card {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            margin-bottom: 25px;
            overflow: hidden;
            background: #fff;
        }

        .property-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .property-details {
            padding: 20px;
        }

        .property-headline {
            font-size: 18px;
            font-weight: 700;
            color: #1E4072;
            margin: 0 0 10px 0;
        }

        .property-meta {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .property-price {
            font-size: 20px;
            font-weight: 700;
            color: #F95CA8;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #F95CA8;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
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
            <h1>Exclusive Property Deals</h1>
        </div>
        <div class="content">
            <p>Hi,</p>
            <p>We thought you might be interested in these exclusive property opportunities sourced recently:</p>

            @foreach($properties as $property)
                <div class="property-card">
                    @if($property->thumbnail)
                        <img src="{{ Str::startsWith($property->thumbnail, 'http') ? $property->thumbnail : asset('storage/' . $property->thumbnail) }}"
                            class="property-img" alt="{{ $property->headline }}">
                    @endif
                    <div class="property-details">
                        <h2 class="property-headline">{{ $property->headline }}</h2>
                        <div class="property-meta">
                            <i class="bi bi-geo-alt"></i> {{ $property->location }} |
                            @if($property->bedrooms) {{ $property->bedrooms }} Bed @endif
                            @if($property->bathrooms) | {{ $property->bathrooms }} Bath @endif
                        </div>
                        <div class="property-price">
                            £{{ number_format($property->price, 0) }}
                            @if($property->discount_available)
                                <small style="font-size: 12px; color: #28a745; font-weight: normal; margin-left: 10px;">Discount
                                    Available</small>
                            @endif
                        </div>
                        <a href="{{ url('/available-properties/' . $property->id) }}" class="btn">View Full Details</a>
                    </div>
                </div>
            @endforeach

            <p>If you're interested in any of these deals or would like to discuss your investment strategy, please feel
                free to contact us.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.<br>
            inquiries@propertysourcinggroup.co.uk
        </div>
    </div>
</body>

</html>