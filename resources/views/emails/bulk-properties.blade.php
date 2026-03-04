<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #f95ca8; }
        .logo { max-width: 150px; }
        .property-card { margin-top: 25px; padding: 15px; border: 1px solid #e1e1e1; border-radius: 8px; background: #fafafa; }
        .property-image { width: 100%; height: 200px; object-fit: cover; border-radius: 5px; }
        .property-headline { color: #f95ca8; margin: 10px 0 5px; font-size: 1.25rem; }
        .property-meta { font-size: 0.9rem; color: #666; margin-bottom: 10px; }
        .property-price { font-weight: bold; color: #2c3e50; font-size: 1.1rem; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #f95ca8; color: white !important; text-decoration: none; border-radius: 5px; margin-top: 10px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 0.8rem; color: #888; text-align: center; border-top: 1px solid #eee; padding-top: 20px; }
        .message { margin-top: 20px; font-style: italic; background: #fff5fa; padding: 10px; border-left: 4px solid #f95ca8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Property Sourcing Group" class="logo">
            <h2>New Property Opportunity</h2>
        </div>

        @if($customMessage)
            <div class="message">
                "{{ $customMessage }}"
                <br>
                <small>- {{ $sender->name }}</small>
            </div>
        @endif

        <p>Hello,</p>
        <p>We are pleased to share the following property opportunities from our network:</p>

        @foreach($properties as $property)
            <div class="property-card">
                @if($property->thumbnail)
                    <img src="{{ Str::startsWith($property->thumbnail, 'http') ? $property->thumbnail : asset('storage/' . $property->thumbnail) }}" class="property-image">
                @endif
                <h3 class="property-headline">{{ $property->headline }}</h3>
                <div class="property-meta">
                    <i class="bi bi-geo-alt"></i> {{ $property->location }} | {{ $property->investment_type }}
                </div>
                <div class="property-price">Price: £{{ number_format($property->price) }}</div>
                <a href="{{ route('available-properties.show', $property->id) }}" class="btn">View Full Details</a>
            </div>
        @endforeach

        <p style="margin-top: 30px;">If you're interested in any of these deals or would like more information, please don't hesitate to reach out.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.</p>
            <p>This email was sent on behalf of {{ $sender->name }} ({{ $sender->email }})</p>
            <p>If you wish to unsubscribe from these notifications, please login to your profile settings.</p>
        </div>
    </div>
</body>
</html>
