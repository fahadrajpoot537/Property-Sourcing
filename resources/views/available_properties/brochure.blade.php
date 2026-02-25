<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Property Brochure - {{ $property->headline }}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0b1c33;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .header {
            background-color: #ffffff;
            color: #1E4072;
            padding: 20px 40px;
            text-align: center;
        }

        .header-top {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .pink-bar {
            background-color: #F95CA8;
            color: white;
            padding: 8px 0;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .container {
            padding: 30px 40px;
        }

        .property-title {
            color: #1E4072;
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .property-location {
            color: #F95CA8;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .main-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 25px;
            display: block;
        }

        .details-grid {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .details-grid td {
            vertical-align: top;
            padding: 10px;
        }

        .section-title {
            color: #1E4072;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #F95CA8;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .details-table .label {
            color: #666;
            width: 40%;
        }

        .details-table .value {
            font-weight: bold;
            color: #1E4072;
            text-align: right;
        }

        .description {
            font-size: 13px;
            color: #555;
            margin-bottom: 30px;
        }

        .description p {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .description ul,
        .description ol {
            margin-bottom: 15px;
            padding-left: 20px;
        }

        .image-gallery {
            width: 100%;
            margin-top: 20px;
        }

        .gallery-item {
            width: 48%;
            float: left;
            margin-right: 2%;
            margin-bottom: 20px;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .user-contact {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #eee;
            border-left: 5px solid #F95CA8;
            margin-top: 30px;
        }

        .user-contact h4 {
            margin: 0 0 10px 0;
            color: #1E4072;
        }

        .contact-info {
            font-size: 14px;
        }

        .contact-item {
            margin-bottom: 5px;
        }

        .footer {
            background-color: #ffffff;
            padding: 20px 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #eee;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .badge {
            background-color: #F95CA8;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>


    <div class="container">
        <div style="margin-bottom: 10px;">
            <span class="badge">{{ $property->marketingPurpose->name ?? 'For Sale' }}</span>
            @if($property->discount_available)
                <span class="badge" style="background-color: #28a745; margin-left: 5px;">Discount Available</span>
            @endif
        </div>

        <div class="property-title">{{ $property->headline }}</div>
        <div class="property-location">{{ $property->location }}</div>

        @if($property->thumbnail && file_exists(public_path('storage/' . $property->thumbnail)))
            <img src="{{ public_path('storage/' . $property->thumbnail) }}" class="main-image">
        @endif

        <table class="details-grid">
            <tr>
                <td width="50%">
                    <div class="section-title">Property Details</div>
                    <table class="details-table">
                        @if($property->propertyType)
                            <tr>
                                <td class="label">Type</td>
                                <td class="value">{{ $property->propertyType->name }}</td>
                            </tr>
                        @endif
                        @if($property->unitType)
                            <tr>
                                <td class="label">Category</td>
                                <td class="value">{{ $property->unitType->name }}</td>
                            </tr>
                        @endif
                        @if($property->area_sq_ft)
                            <tr>
                                <td class="label">Area</td>
                                <td class="value">{{ $property->area_sq_ft }} sq ft</td>
                            </tr>
                        @endif
                        @if($property->bedrooms)
                            <tr>
                                <td class="label">Bedrooms</td>
                                <td class="value">{{ $property->bedrooms }}</td>
                            </tr>
                        @endif
                        @if($property->bathrooms)
                            <tr>
                                <td class="label">Bathrooms</td>
                                <td class="value">{{ $property->bathrooms }}</td>
                            </tr>
                        @endif
                        @if($property->price)
                            <tr>
                                <td class="label">Price</td>
                                <td class="value">£{{ number_format($property->price, 2) }}</td>
                            </tr>
                        @endif
                        @if($property->latitude && $property->longitude)
                            <tr>
                                <td class="label">Coordinates</td>
                                <td class="value">{{ $property->latitude }}, {{ $property->longitude }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
                <td width="50%">
                    <div class="section-title">Investment Stats</div>
                    <table class="details-table">
                        @if($property->investment_type)
                            <tr>
                                <td class="label">Strategy</td>
                                <td class="value">{{ ucfirst(str_replace('_', ' ', $property->investment_type)) }}</td>
                            </tr>
                        @endif
                        @if($property->current_value)
                            <tr>
                                <td class="label">Current Value</td>
                                <td class="value">£{{ number_format($property->current_value, 2) }}</td>
                            </tr>
                        @endif
                        @if($property->purchase_date)
                            <tr>
                                <td class="label">Purchase Date</td>
                                <td class="value">{{ $property->purchase_date->format('d M Y') }}</td>
                            </tr>
                        @endif
                        @if($property->investment_type == 'rental')
                            @if($property->monthly_rent)
                                <tr>
                                    <td class="label">Est. Monthly Rent</td>
                                    <td class="value">£{{ number_format($property->monthly_rent, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="label">Tenanted</td>
                                <td class="value">{{ $property->is_currently_rented ? 'Yes' : 'No' }}</td>
                            </tr>
                        @elseif($property->investment_type == 'buy_to_sell')
                            @if($property->sale_price)
                                <tr>
                                    <td class="label">Target Sale Price</td>
                                    <td class="value">£{{ number_format($property->sale_price, 2) }}</td>
                                </tr>
                            @endif
                            @if($property->sale_date)
                                <tr>
                                    <td class="label">Sale Date</td>
                                    <td class="value">{{ $property->sale_date->format('d M Y') }}</td>
                                </tr>
                            @endif
                        @endif
                        @if($property->tenure_type)
                            <tr>
                                <td class="label">Tenure</td>
                                <td class="value">{{ ucfirst($property->tenure_type) }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        @if($property->financing_type)
            <div class="section-title">Financial Details</div>
            <table class="details-table" style="width: 50%; margin-bottom: 30px;">
                <tr>
                    <td class="label">Financing Type</td>
                    <td class="value">{{ ucfirst($property->financing_type) }}</td>
                </tr>
                @if($property->loan_amount)
                    <tr>
                        <td class="label">Loan Amount</td>
                        <td class="value">£{{ number_format($property->loan_amount, 2) }}</td>
                    </tr>
                @endif
                @if($property->interest_rate)
                    <tr>
                        <td class="label">Interest Rate</td>
                        <td class="value">{{ number_format($property->interest_rate, 2) }}%</td>
                    </tr>
                @endif
                @if($property->lender_name)
                    <tr>
                        <td class="label">Lender</td>
                        <td class="value">{{ $property->lender_name }}</td>
                    </tr>
                @endif
                @if($property->monthly_payment)
                    <tr>
                        <td class="label">Monthly Payment</td>
                        <td class="value">£{{ number_format($property->monthly_payment, 2) }}</td>
                    </tr>
                @endif
            </table>
        @endif

        <div class="section-title">Description</div>
        <div class="description">
            {!! $property->full_description !!}
        </div>

        @if($property->latitude && $property->longitude)
            <div class="section-title">Location Map</div>
            <div style="margin-bottom: 30px; text-align: center;">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $property->latitude }},{{ $property->longitude }}&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7C{{ $property->latitude }},{{ $property->longitude }}&key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI"
                    style="width: 100%; border-radius: 10px; border: 1px solid #eee;">
                <div style="font-size: 11px; color: #888; margin-top: 5px;">{{ $property->location }}</div>
            </div>
        @endif

        @if($property->tenure_type == 'leasehold')
            <div class="section-title">Lease Details</div>
            <table class="details-table" style="width: 50%;">
                @if($property->lease_years_remaining)
                    <tr>
                        <td class="label">Lease Remaining</td>
                        <td class="value">{{ $property->lease_years_remaining }} Years</td>
                    </tr>
                @endif
                @if($property->service_charge)
                    <tr>
                        <td class="label">Service Charge</td>
                        <td class="value">£{{ number_format($property->service_charge, 2) }}</td>
                    </tr>
                @endif
                @if($property->ground_rent)
                    <tr>
                        <td class="label">Ground Rent</td>
                        <td class="value">£{{ number_format($property->ground_rent, 2) }}</td>
                    </tr>
                @endif
            </table>
            <br>
        @endif

        @if($property->costs->count() > 0)
            <div class="section-title">Associated Costs</div>
            <table class="details-table" style="width: 100%; margin-bottom: 30px;">
                @foreach($property->costs as $cost)
                    <tr>
                        <td class="label">{{ $cost->name }}</td>
                        <td class="value">£{{ number_format($cost->amount, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if($property->tenants->count() > 0)
            <div class="section-title">Tenant Information</div>
            <table class="details-table" style="width: 100%; margin-bottom: 30px;">
                @foreach($property->tenants as $tenant)
                    <tr>
                        <td class="label">{{ $tenant->name }} @if($tenant->is_primary) (Primary) @endif</td>
                        <td class="value">
                            @if($tenant->phone) {{ $tenant->phone }} @endif
                            @if($tenant->email) | {{ $tenant->email }} @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <div class="section-title">Compliance</div>
        <table class="details-grid">
            <tr>
                <td width="50%">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 5px;">Gas Safety</div>
                    <div style="font-size: 12px; color: #666;">
                        Issue:
                        {{ $property->gas_safety_issue_date ? $property->gas_safety_issue_date->format('d M Y') : 'N/A' }}<br>
                        Expiry:
                        {{ $property->gas_safety_expiry_date ? $property->gas_safety_expiry_date->format('d M Y') : 'N/A' }}
                    </div>
                </td>
                <td width="50%">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 5px;">Electrical Safety (EICR)</div>
                    <div style="font-size: 12px; color: #666;">
                        Issue:
                        {{ $property->electrical_issue_date ? $property->electrical_issue_date->format('d M Y') : 'N/A' }}<br>
                        Expiry:
                        {{ $property->electrical_expiry_date ? $property->electrical_expiry_date->format('d M Y') : 'N/A' }}
                    </div>
                </td>
            </tr>
        </table>

        @if($property->gallery_images)
            <div style="page-break-before: always;"></div>
            <div class="section-title" style="margin-top: 40px;">Photo Gallery</div>
            <table width="100%" cellspacing="15" cellpadding="0" style="margin-left: -15px;">
                @foreach(array_chunk($property->gallery_images, 2) as $row)
                    <tr>
                        @foreach($row as $image)
                            <td width="50%" style="vertical-align: top; padding: 10px;">
                                @if(file_exists(public_path('storage/' . $image)))
                                    <img src="{{ public_path('storage/' . $image) }}"
                                        style="width: 100%; height: auto; border-radius: 8px; display: block;">
                                @endif
                            </td>
                        @endforeach
                        @if(count($row) < 2)
                            <td width="50%"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif

        <div class="user-contact">
            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Contact Information
            </h4>
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="60%" style="vertical-align: top;">
                        <div class="contact-info">
                            <div class="contact-item" style="font-size: 16px; font-weight: bold; color: #1E4072;">
                                {{ $user->name }}
                            </div>
                            <div class="contact-item" style="color: #666;">{{ $user->email }}</div>
                            @if($user->phone)
                                <div class="contact-item" style="color: #666;">{{ $user->phone }}</div>
                            @endif
                        </div>
                    </td>
                    <td width="40%" style="text-align: right; vertical-align: middle;">
                        <img src="{{ public_path('logo.png') }}" style="height: 40px; opacity: 0.8;">
                    </td>
                </tr>
            </table>

            <div style="margin-top: 25px;">
                <table width="100%" cellspacing="10" cellpadding="0" style="margin-left: -10px; margin-right: -10px;">
                    <tr>
                        <td width="33%">
                            <a href="mailto:{{ $user->email }}"
                                style="display: block; padding: 12px 5px; background-color: #1E4072; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 12px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <span style="font-size: 14px;">✉</span> Email
                            </a>
                        </td>
                        @if($user->phone)
                            <td width="33%">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}"
                                    style="display: block; padding: 12px 5px; background-color: #25D366; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 12px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <span style="font-size: 14px;">✆</span> WhatsApp
                                </a>
                            </td>
                            <td width="33%">
                                <a href="tel:{{ $user->phone }}"
                                    style="display: block; padding: 12px 5px; background-color: #F95CA8; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 12px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <span style="font-size: 14px;">☎</span> Call Now
                                </a>
                            </td>
                        @endif
                    </tr>
                </table>
            </div>
            <div
                style="margin-top: 15px; font-size: 10px; color: #999; text-align: center; border-top: 1px solid #fafafa; padding-top: 10px;">
                Download provided by Property Sourcing Group. Connect with our experts today.
            </div>
        </div>
    </div>

</body>

</html>