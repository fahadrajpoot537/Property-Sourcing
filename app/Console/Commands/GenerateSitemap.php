<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AvailableProperty;
use App\Models\News;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the XML sitemap for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

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
            if (Route::has($routeName)) {
                $sitemap->add(
                    Url::create(route($routeName))
                        ->setLastModificationDate(Carbon::now()->startOfDay())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            }
        }

        // 3. News / Blog Posts
        $this->info('Adding blog posts...');
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
        $this->info('Adding available properties...');
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

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at ' . public_path('sitemap.xml'));
    }
}
