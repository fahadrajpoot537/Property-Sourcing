<?php

namespace App\Services;

use App\Models\AvailableProperty;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class PropertyImageGeneratorService
{
    protected $manager;
    protected $brandBlue = '#003E6B';
    protected $brandPink = '#F95CA8';
    protected $fontPath;
    protected $logoPath;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        // Path to font (from DomPDF as discovered)
        $this->fontPath = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSans.ttf');
        $this->logoPath = public_path('logo.png');
    }

    /**
     * Generate Instagram Carousel for a property.
     */
    public function generateCarousel(AvailableProperty $property)
    {
        try {
            $outputDir = public_path("posts/{$property->id}");
            if (!File::exists($outputDir)) {
                File::makeDirectory($outputDir, 0755, true);
            }

            $generatedImages = [];

            // 1. Generate Cover Slide
            $coverPath = $this->generateCoverSlide($property, $outputDir);
            if ($coverPath) {
                $generatedImages[] = "posts/{$property->id}/cover.jpg";
            }

            // 2. Generate Gallery Slides (up to 5 images)
            $gallery = $property->gallery_images;
            if (is_array($gallery)) {
                $count = 1;
                foreach (array_slice($gallery, 0, 5) as $imagePath) {
                    $slidePath = $this->generateGallerySlide($imagePath, $outputDir, $count, $property->id);
                    if ($slidePath) {
                        $generatedImages[] = "posts/{$property->id}/slide_{$count}.jpg";
                        $count++;
                    }
                }
            }

            // 3. Generate Contact/Call to Action Slide
            $contactPath = $this->generateContactSlide($property, $outputDir);
            if ($contactPath) {
                $generatedImages[] = "posts/{$property->id}/contact.jpg";
            }

            // Store in database
            $property->update([
                'generated_posts' => $generatedImages
            ]);

            return $generatedImages;

        } catch (\Exception $e) {
            Log::error("Failed to generate Instagram carousel for property {$property->id}: " . $e->getMessage());
            throw $e;
        }
    }

    private function wrapText($text, $maxWidth, $fontSize)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        $charWidth = $fontSize * 0.55;
        $maxChars = floor($maxWidth / $charWidth);

        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= $maxChars) {
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                $lines[] = $currentLine;
                $currentLine = $word;
            }
        }
        if ($currentLine) {
            $lines[] = $currentLine;
        }

        return !empty($lines) ? $lines : [$text];
    }

    private function generateCoverSlide(AvailableProperty $property, $outputDir)
    {
        // 1. Data Calculation
        $originalPrice = (float) $property->price;
        $salePrice = (float) $property->sale_price;
        $discountAmount = $originalPrice - $salePrice;
        $discountPercent = 0;
        if ($originalPrice > 0) {
            $discountPercent = round(($discountAmount / $originalPrice) * 100);
        }

        // 2. Base Canvas
        $canvas = $this->manager->create(1080, 1080)->fill($this->brandBlue);

        // 3. Background: Blurred Property Image with modern "Zoom" feel
        if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
            $bg = $this->manager->read(Storage::disk('public')->path($property->thumbnail));
            $bg->scale(width: 1500); // Scale up for zoom feel
            $bg->cover(1080, 1080);
            $bg->blur(5); // Reduced blur for better clarity
            $canvas->place($bg);

            // Modern Blue-ish Overlay (Not just plain black)
            $canvas->drawRectangle(0, 0, function ($draw) {
                $draw->background('rgba(0, 62, 107, 0.7)'); // 70% opacity brand blue
                $draw->size(1080, 1080);
            });
        }

        // 4. Top Ribbon Design (Modern & Slanted look)
        $canvas->drawRectangle(0, 0, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(1080, 120);
        });
        // Decorative pink line under header
        $canvas->drawRectangle(0, 120, function ($draw) {
            $draw->background($this->brandPink);
            $draw->size(1080, 6);
        });

        if (File::exists($this->logoPath)) {
            $logo = $this->manager->read($this->logoPath);
            $logo->scale(height: 70);
            $canvas->place($logo, 'top-left', 60, 25);
        }

        // 5. Exclusive Deal Badge (Top Right)
        $canvas->drawRectangle(700, 30, function ($draw) {
            $draw->background($this->brandPink);
            $draw->size(350, 60);
        });
        $canvas->text("HOT INVESTMENT DEAL", 875, 60, function ($font) {
            $font->filename($this->fontPath);
            $font->size(22);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // 6. Main Property Feature Image (White Border & Shadow effect)
        $canvas->drawRectangle(95, 215, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(890, 490);
        });
        if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
            $img = $this->manager->read(Storage::disk('public')->path($property->thumbnail));
            $img->cover(870, 470);
            $canvas->place($img, 'top', 0, 225);
        }

        // 7. Discount Circle Badge (Overlaying image corner)
        $canvas->drawCircle(950, 230, function ($draw) {
            $draw->background($this->brandPink);
            $draw->radius(100);
            $draw->border('#ffffff', 4);
        });
        $canvas->text($discountPercent . "%", 950, 215, function ($font) {
            $font->filename($this->fontPath);
            $font->size(50);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });
        $canvas->text("OFF MARKET", 950, 260, function ($font) {
            $font->filename($this->fontPath);
            $font->size(18);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // 8. Headline & Content section
        $headline = strtoupper($property->headline);
        $headerLines = $this->wrapText($headline, 900, 48);
        $yHeader = 750;
        foreach (array_slice($headerLines, 0, 2) as $line) {
            $canvas->text($line, 540, $yHeader, function ($font) {
                $font->filename($this->fontPath);
                $font->size(48);
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('middle');
            });
            $yHeader += 60;
        }

        $canvas->text($property->location, 540, $yHeader + 10, function ($font) {
            $font->filename($this->fontPath);
            $font->size(28);
            $font->color($this->brandPink);
            $font->align('center');
            $font->valign('middle');
        });

        // 9. Modern Pricing Comparison Row
        $yPriceBase = 960;

        // Background for the price row
        $canvas->drawRectangle(100, $yPriceBase - 50, function ($draw) {
            $draw->background('rgba(255, 255, 255, 0.1)');
            $draw->size(880, 100);
        });

        // WAS
        $canvas->text("Original: £" . number_format($originalPrice), 300, $yPriceBase, function ($font) {
            $font->filename($this->fontPath);
            $font->size(30);
            $font->color('#cccccc');
            $font->align('center');
            $font->valign('middle');
        });
        // Strikethrough
        $canvas->drawRectangle(180, $yPriceBase, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(250, 2);
        });

        // BUY (High Impact)
        $canvas->text("SALE: £" . number_format($salePrice), 780, $yPriceBase, function ($font) {
            $font->filename($this->fontPath);
            $font->size(55);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });
        // Highlight shadow under Buy
        $canvas->drawRectangle(650, $yPriceBase + 35, function ($draw) {
            $draw->background($this->brandPink);
            $draw->size(260, 4);
        });

        // 10. Bottom Contact Info
        $canvas->drawRectangle(0, 1020, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(1080, 60);
        });
        $contactText = "www.propertysourcinggroup.co.uk  |  info@propertysourcinggroup.co.uk  |  0203 468 0480";
        $canvas->text($contactText, 540, 1050, function ($font) {
            $font->filename($this->fontPath);
            $font->size(20);
            $font->color($this->brandBlue);
            $font->align('center');
            $font->valign('middle');
        });

        $canvas->save($outputDir . '/cover.jpg', 100);
        return true;
    }

    private function generateGallerySlide($imagePath, $outputDir, $index, $propertyId)
    {
        if (!Storage::disk('public')->exists($imagePath)) {
            return false;
        }

        $canvas = $this->manager->create(1080, 1080)->fill($this->brandBlue);

        // Header bar with logo
        $canvas->drawRectangle(0, 0, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(1080, 100);
        });
        if (File::exists($this->logoPath)) {
            $logo = $this->manager->read($this->logoPath);
            $logo->scale(height: 60);
            $canvas->place($logo, 'top-left', 40, 20);
        }

        // Image with thin white border
        $img = $this->manager->read(Storage::disk('public')->path($imagePath));
        $img->cover(1000, 800);
        $canvas->place($img, 'center', 0, 40);

        // Bottom Accent
        $canvas->drawRectangle(0, 1000, function ($draw) {
            $draw->background($this->brandPink);
            $draw->size(1080, 80);
        });
        $canvas->text("INVESTMENT OPPORTUNITY  |  PSG", 540, 1040, function ($font) {
            $font->filename($this->fontPath);
            $font->size(24);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        $canvas->save($outputDir . "/slide_{$index}.jpg", 100);
        return true;
    }

    private function generateContactSlide(AvailableProperty $property, $outputDir)
    {
        $canvas = $this->manager->create(1080, 1080)->fill($this->brandBlue);

        // Blurred background for consistency
        if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
            $bg = $this->manager->read(Storage::disk('public')->path($property->thumbnail));
            $bg->cover(1080, 1080);
            $bg->blur(10); // Reduced blur
            $canvas->place($bg);
            $canvas->drawRectangle(0, 0, function ($draw) {
                $draw->background('rgba(0, 62, 107, 0.8)');
                $draw->size(1080, 1080);
            });
        }

        // Modern floating card
        $canvas->drawRectangle(100, 100, function ($draw) {
            $draw->background('#ffffff');
            $draw->size(880, 880);
        });

        if (File::exists($this->logoPath)) {
            $logo = $this->manager->read($this->logoPath);
            $logo->scale(height: 140);
            $canvas->place($logo, 'top-center', 0, 160);
        }

        $canvas->text("INTERESTED IN THIS DEAL?", 540, 380, function ($font) {
            $font->filename($this->fontPath);
            $font->size(38);
            $font->color($this->brandBlue);
            $font->align('center');
            $font->valign('middle');
        });

        // Contact info with better labels
        $y = 480;
        $details = [
            'CALL US: 0203 468 0480',
            'EMAIL: info@propertysourcinggroup.co.uk',
            'VISIT: propertysourcinggroup.co.uk'
        ];

        foreach ($details as $detail) {
            $canvas->text($detail, 540, $y, function ($font) {
                $font->filename($this->fontPath);
                $font->size(28);
                $font->color('#555555');
                $font->align('center');
                $font->valign('middle');
            });
            $y += 80;
        }

        // Call to action button
        $canvas->drawRectangle(240, 750, function ($draw) {
            $draw->background($this->brandPink);
            $draw->size(600, 120);
        });

        $canvas->text("SECURE DEAL NOW", 540, 810, function ($font) {
            $font->filename($this->fontPath);
            $font->size(40);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        $canvas->save($outputDir . '/contact.jpg', 100);
        return true;
    }
}
