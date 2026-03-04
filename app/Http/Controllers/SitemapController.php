<?php

namespace App\Http\Controllers;

use App\Models\AvailableProperty;
use App\Models\News;
use App\Models\Property;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // 1. Homepage
        $sitemap->add(
            Url::create(route('home'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );

        // 2. Static Pages
        $staticPages = [
            'how-it-works',
            'why-choose-us',
            'meet-the-team',
            'podcast',
            'become-investor',
            'investor-event',
            'contact',
            'faq',
            'news.index',
            'properties.index',
        ];

        foreach ($staticPages as $routeName) {
            if (\Route::has($routeName)) {
                $sitemap->add(
                    Url::create(route($routeName))
                        ->setLastModificationDate(Carbon::now()->startOfDay())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            }
        }

        // 3. News / Blog Posts
        News::whereNotNull('published_at')->chunk(500, function ($posts) use ($sitemap) {
            foreach ($posts as $post) {
                $sitemap->add(
                    Url::create(route('news.show', $post->slug))
                        ->setLastModificationDate($post->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7)
                );
            }
        });

        // 4. Available Properties (Approved)
        AvailableProperty::where('status', 'approved')->chunk(500, function ($properties) use ($sitemap) {
            foreach ($properties as $property) {
                $sitemap->add(
                    Url::create(route('available-properties.show', $property->id))
                        ->setLastModificationDate($property->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.9)
                );
            }
        });

        // 5. General Properties
        Property::chunk(500, function ($properties) use ($sitemap) {
            foreach ($properties as $property) {
                // If there's a show route for general properties, add it here.
                // Based on web.php, it seems properties might not have a public single show route for the old model.
                // But we include them if relevant.
            }
        });

        return $sitemap->toResponse(request());
    }
}
