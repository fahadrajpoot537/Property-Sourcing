<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insta Post Setup - {{ $property->headline }}</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .controls {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 20px;
            z-index: 10000;
        }

        .controls h2 {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            color: #1E4072;
        }

        .btn-download {
            background: #F95CA8;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(249, 92, 168, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-download:hover {
            background: #d14088;
        }

        .slides-container {
            display: flex;
            flex-direction: column;
            gap: 50px;
            align-items: center;
        }

        /* 1080x1080 slide wrapper */
        .insta-slide {
            width: 1080px;
            height: 1080px;
            background: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            /* Scaling for view */
            transform-origin: top center;
            transform: scale(0.65);
            margin-bottom: -378px;
            /* to compensate for scale 0.65: 1080 - (1080*0.65) = 378 */
        }

        /* Slide 1 - Main */
        .slide-main {
            background: linear-gradient(135deg, #1E4072 0%, #0b1c33 100%);
            color: white;
        }

        .logo-top-box {
            position: absolute;
            top: 30px;
            left: 50px;
            z-index: 10;
            background: #ffffff;
            padding: 15px 30px;
            border-radius: 15px;
        }

        .logo-top {
            height: 90px;
            display: block;
        }

        .main-img-wrapper {
            position: absolute;
            top: 190px;
            right: 50px;
            width: 700px;
            height: 600px;
            border-radius: 20px;
            overflow: hidden;
            border: 10px solid white;
            background: #eee;
        }

        .main-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .features-list {
            position: absolute;
            top: 220px;
            left: 50px;
            width: 300px;
        }

        .feat-item {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 500;
        }

        .feat-item i {
            color: #08c3e1;
            margin-right: 15px;
            font-size: 28px;
        }

        .headline-box {
            position: absolute;
            bottom: 50px;
            left: 50px;
            width: 980px;
            background: #ffffff;
            color: #1E4072;
            padding: 50px 60px;
            border-radius: 25px;
            border-left: 15px solid #F95CA8;
        }

        .hl-title {
            font-family: 'Outfit', sans-serif;
            font-size: 52px;
            font-weight: 800;
            margin: 0 0 15px 0;
            line-height: 1.25;
            color: #1E4072;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hl-location {
            font-size: 30px;
            color: #666;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .hl-location i {
            color: #F95CA8;
            margin-right: 12px;
        }

        .price-row {
            display: flex;
            gap: 60px;
            align-items: center;
        }

        .price-col {
            display: flex;
            flex-direction: column;
        }

        .price-lbl {
            font-size: 22px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .price-val {
            font-size: 56px;
            font-weight: 800;
            font-family: 'Outfit';
        }

        .val-strike {
            text-decoration: line-through;
            color: #aaa;
            font-size: 40px;
        }

        .val-sale {
            color: #08c3e1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .discount-badge {
            position: absolute;
            top: 50px;
            right: 50px;
            background: #F95CA8;
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 42px;
            font-weight: 800;
            font-family: 'Outfit';
            box-shadow: 0 15px 30px rgba(249, 92, 168, 0.5);
            transform: rotate(6deg);
            z-index: 20;
        }

        .discount-badge small {
            font-size: 24px;
            font-weight: 600;
            display: block;
            margin-top: -10px;
            opacity: 0.9;
            text-align: center;
        }

        .saving-box {
            display: inline-flex;
            align-items: center;
            background: rgba(8, 195, 225, 0.15);
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid #08c3e1;
            margin-top: 15px;
        }

        .saving-box i {
            color: #08c3e1;
            font-size: 28px;
            margin-right: 15px;
        }

        .saving-text {
            color: #1E4072;
            font-weight: 700;
            font-size: 22px;
        }

        .saving-amount {
            color: #08c3e1;
            font-weight: 800;
            font-family: 'Outfit';
            font-size: 28px;
        }

        /* Slide - Gallery */
        .slide-gallery {
            background: #f4f6f9;
        }

        .gallery-img-wrapper {
            width: 100%;
            height: 100%;
            background: #ddd;
        }

        .gallery-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 60px 50px 40px 50px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0) 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .gallery-logo {
            position: absolute;
            top: 50px;
            left: 50px;
            height: 80px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.6));
        }

        .g-prop-title {
            font-family: 'Outfit', sans-serif;
            font-size: 40px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
        }

        /* Slide - Contact */
        .slide-contact {
            background: linear-gradient(135deg, #1E4072 0%, #0b1c33 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .logo-large-box {
            background: #ffffff;
            padding: 30px 60px;
            border-radius: 20px;
            margin-bottom: 60px;
            display: inline-block;
        }

        .slide-contact .logo-large {
            height: 100px;
            display: block;
        }

        .contact-title {
            font-family: 'Outfit';
            font-size: 72px;
            font-weight: 800;
            color: #F95CA8;
            margin-bottom: 20px;
        }

        .contact-subtitle {
            font-size: 28px;
            color: #08c3e1;
            margin-bottom: 80px;
            font-weight: 500;
        }

        .contact-item {
            display: flex;
            align-items: center;
            font-size: 42px;
            font-weight: 600;
            margin-bottom: 35px;
            background: rgba(255, 255, 255, 0.08);
            padding: 30px 50px;
            border-radius: 80px;
            width: 850px;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .contact-item i {
            font-size: 55px;
            color: #08c3e1;
            margin-right: 40px;
            width: 70px;
            text-align: center;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 100000;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Outfit', sans-serif;
        }

        .loading-overlay h2 {
            color: #1E4072;
            margin-top: 20px;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid #F95CA8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="controls">
        <h2>Instagram Carousel - {{ $property->headline }}</h2>
        <button class="btn-download" id="btnDownload">
            <i class="bi bi-download"></i> Download All as ZIP
        </button>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <h2 id="loadingText">Generating Images...</h2>
    </div>

    <div class="slides-container" id="slidesContainer">

        @php
            $salePrice = $property->portal_sale_price ?? $property->price;

            // Prioritize current_value, fallback to market_value_avg
            $originPrice = $property->current_value > 0 ? $property->current_value :
                ($property->market_value_avg > 0 ? $property->market_value_avg : null);

            // Fallback for when originPrice is still null, calculate from min and max directly
            if (!$originPrice && $property->market_value_min > 0 && $property->market_value_max > 0) {
                $originPrice = ($property->market_value_min + $property->market_value_max) / 2;
            }

            $discountPct = null;
            if ($originPrice && $salePrice < $originPrice) {
                $discountPct = (($originPrice - $salePrice) / $originPrice) * 100;
            }
        @endphp

        <!-- 1. Main Slide -->
        <div class="insta-slide slide-main" data-filename="01_main.png">
            @if($logoBase64)
                <div class="logo-top-box">
                    <img src="{{ $logoBase64 }}" class="logo-top" alt="Logo">
                </div>
            @endif

            @if($discountPct && $discountPct > 0)
                <div class="discount-badge">
                    {{ number_format($discountPct, 0) }}% OFF
                    <small>BMV DEAL</small>
                </div>
            @endif

            <ul class="features-list">
                @if($property->bedrooms)
                    <li class="feat-item"><i class="bi bi-door-closed"></i> {{ $property->bedrooms }} Bedrooms</li>
                @endif
                @if($property->bathrooms)
                    <li class="feat-item"><i class="bi bi-droplet"></i> {{ $property->bathrooms }} Bathrooms</li>
                @endif
                @if($property->propertyType)
                    <li class="feat-item"><i class="bi bi-house"></i> {{ $property->propertyType->name }}</li>
                @endif
                @if($property->investment_type)
                    <li class="feat-item"><i class="bi bi-graph-up-arrow"></i>
                        {{ ucfirst(str_replace('_', ' ', $property->investment_type)) }}</li>
                @endif
                @if($property->yearly_rent)
                    <li class="feat-item"><i class="bi bi-cash-stack"></i> Yield:
                        {{ number_format(($property->yearly_rent / $salePrice) * 100, 1) }}%
                    </li>
                @endif
            </ul>

            <div class="main-img-wrapper">
                @if($property->thumbnail && Storage::disk('public')->exists($property->thumbnail))
                    @php
                        $thumbData = Storage::disk('public')->get($property->thumbnail);
                        $thumb64 = 'data:image/jpeg;base64,' . base64_encode($thumbData);
                    @endphp
                    <img src="{{ $thumb64 }}" alt="Thumbnail">
                @else
                    <div
                        style="width:100%; height:100%; background:#ccc; display:flex; align-items:center; justify-content:center; font-size:40px; color:#666;">
                        No Image</div>
                @endif
            </div>

            <div class="headline-box">
                <h1 class="hl-title">{{ $property->headline }}</h1>
                <div class="hl-location"><i class="bi bi-geo-alt-fill"></i> {{ $property->location }}</div>

                <div class="price-row">
                    @if($originPrice && $originPrice > $salePrice)
                        <div class="price-col">
                            <span class="price-lbl" style="color:#F95CA8 !important">Current Value</span>
                            <span class="price-val val-strike"
                                style="color:#F95CA8 !important">£{{ number_format($originPrice, 0) }}</span>
                        </div>
                    @endif
                    <div class="price-col">
                        <span class="price-lbl">Asking Price</span>
                        <span class="price-val val-sale">£{{ number_format($salePrice, 0) }}</span>
                    </div>
                </div>

                @if($originPrice && $originPrice > $salePrice)
                    <div class="saving-box">
                        <i class="bi bi-graph-down-arrow"></i>
                        <div class="saving-text">Instant Equity / Saving: <span
                                class="saving-amount">£{{ number_format($originPrice - $salePrice, 0) }}</span></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Gallery Slides -->
        @if($property->gallery_images)
            @foreach($property->gallery_images as $index => $image)
                @if(Storage::disk('public')->exists($image))
                    @php
                        $imgData = Storage::disk('public')->get($image);
                        $img64 = 'data:image/jpeg;base64,' . base64_encode($imgData);
                    @endphp
                    <div class="insta-slide slide-gallery" data-filename="{{ sprintf('%02d_gallery.png', $index + 2) }}">
                        <div class="gallery-img-wrapper">
                            <img src="{{ $img64 }}" alt="Gallery">
                        </div>
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" class="gallery-logo" alt="Logo">
                        @endif
                        <div class="gallery-overlay">
                            <h2 class="g-prop-title">{{ $property->headline }}</h2>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <!-- Last Slide - Contact -->
        <div class="insta-slide slide-contact" data-filename="99_contact.png">
            @if($logoBase64)
                <div class="logo-large-box">
                    <img src="{{ $logoBase64 }}" class="logo-large" alt="Logo">
                </div>
            @endif

            <h1 class="contact-title">Interested?</h1>
            <p class="contact-subtitle">Get in touch to secure this deal today!</p>

            <div class="contact-item">
                <i class="bi bi-telephone-fill"></i> 0203 468 0480
            </div>
            <div class="contact-item">
                <i class="bi bi-envelope-fill"></i> info@propertysourcinggroup.co.uk
            </div>
            <div class="contact-item" style="margin-bottom: 100px;">
                <i class="bi bi-globe"></i> www.propertysourcinggroup.co.uk
            </div>
        </div>

    </div>

    <!-- html2canvas and jszip libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <script>
        document.getElementById('btnDownload').addEventListener('click', async function () {
            const overlay = document.getElementById('loadingOverlay');
            const statusText = document.getElementById('loadingText');
            overlay.style.display = 'flex';

            try {
                const zip = new JSZip();
                const slides = document.querySelectorAll('.insta-slide');

                for (let i = 0; i < slides.length; i++) {
                    const slide = slides[i];
                    const filename = slide.getAttribute('data-filename');
                    statusText.innerText = `Generating Image ${i + 1} of ${slides.length}...`;

                    // Temporarily remove transform scaling to render at exactly 1080x1080 resolution
                    const originalTransform = slide.style.transform;
                    slide.style.transform = 'none';

                    const canvas = await html2canvas(slide, {
                        scale: 1, // Already 1080px wide natively
                        useCORS: true,
                        backgroundColor: null
                    });

                    // Restore scaling
                    slide.style.transform = originalTransform;

                    const btnBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
                    zip.file(filename, btnBlob);
                }

                statusText.innerText = "Zipping files...";
                const zipBlob = await zip.generateAsync({ type: "blob" });

                const propName = "{{ preg_replace('/[^A-Za-z0-9_\-]/', '_', $property->headline) }}";
                saveAs(zipBlob, `Insta_Post_${propName}.zip`);

            } catch (error) {
                console.error('Error generating post images:', error);
                alert("An error occurred while generating images. Check the console.");
            } finally {
                overlay.style.display = 'none';
            }
        });
    </script>
</body>

</html>