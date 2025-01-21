<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;
use App\Models\Article; // Replace with your actual model
use App\Models\Offer;   // Replace with your actual model

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap for the application';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add static routes
        $this->addStaticRoutes($sitemap);

        // Add dynamic content (e.g., articles and offers)
        $this->addDynamicContent($sitemap);

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }

    /**
     * Add static routes to the sitemap.
     *
     * @param \Spatie\Sitemap\Sitemap $sitemap
     * @return void
     */
    private function addStaticRoutes(Sitemap $sitemap)
    {
        // Define excluded URLs
        $excludedUrls = [
            '/admin-dash',
            '/admin/*',
            '/upload-image',
            '/dashboard/account',
            '/dashboard/account#security',
            '/chat/{chatRoomId}',
            '/block/{userId}',
            '/unblock/{userId}',
            '/notifications',
            '/json/unreadMessages/count/{id}',
            '/notifications/unread-count',
            '/login',
            '/register',
            '/password/forgot',
            '/password/reset/{token}',
            '/comments/delete/{id}',
            '/captcha/',
            '/captcha/*',
            '/_ignition/*',
            '/admin-dash/*',
            '/notifications/*',
            '/blog/article/create',
            '/blog/article/store',
            '/blog/article/update',
            '/offers/create',
            '/offers/{offer}/edit',
            '/offers/{offer}',
            '/offers/{id}/update-status/done',
            '/place-bid/{offer}',
            '/store-bid',
            '/rec-bids/{offerId}',
            '/my-bids',
            '/bids/{bidId}/accept',
            '/logout',
            '/dashboard',
            '/update-account',
            '/update-password',
            '/chat/*',
            '/chat',
            '/block/*',
            '/block',
            '/unblock',
            '/ublock/*',
            '/json/*',
            '/login-proc',
            '/password/*',
            '//',
            '/get-categories/{divisionId}',
            '/offers/{id}/update-status/done',
            '/unblock/{userId}',
            '/login_proc',
            '/article/{slug}/{date',
            '/comments',
            '/comments/*'
        ];

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();
            
            // Remove query parameters for comparison
            $uri = explode('?', $uri)[0];

            if ($this->isExcludedUrl($uri, $excludedUrls)) {
                continue;
            }

            $sitemap->add(Url::create('/' . $uri)
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );
        }
    }

    /**
     * Add dynamic content (e.g., articles and offers) to the sitemap.
     *
     * @param \Spatie\Sitemap\Sitemap $sitemap
     * @return void
     */
    private function addDynamicContent(Sitemap $sitemap)
    {
        // Add blog articles
        $articles = Article::all(); // Replace with your actual model and query

        foreach ($articles as $article) {
            $sitemap->add(Url::create('/blog/article/' . $article->slug) // Adjust URL structure as needed
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
            );
        }

        // Add offers
        $offers = Offer::all(); // Replace with your actual model and query

        foreach ($offers as $offer) {
            $sitemap->add(Url::create('/offers/' . $offer->id) // Adjust URL structure as needed
                ->setLastModificationDate($offer->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );
        }
    }

    /**
     * Check if a URI should be excluded from the sitemap.
     *
     * @param string $uri
     * @param array $excludedUrls
     * @return bool
     */
    private function isExcludedUrl(string $uri, array $excludedUrls): bool
    {
        foreach ($excludedUrls as $excludedUrl) {
            // Escape special characters in the excluded URL pattern
            $pattern = '/^' . preg_quote($excludedUrl, '/') . '$/';
            
            // Convert parameter placeholders to match any characters
            $pattern = str_replace(['\{id\}', '\{token\}', '\{chatRoomId\}', '\{userId\}'], ['\d+', '[\w-]+', '\d+', '\d+'], $pattern);

            // Handle wildcard (*) in patterns
            $pattern = str_replace('\*', '.*', $pattern);

            // Debug output to see the pattern and URL being matched (optional)
            // \Log::info("Matching URL: $uri with pattern: $pattern");
            
            // Ensure the pattern is matching the URI correctly
            if (preg_match($pattern, '/' . $uri)) {
                return true;
            }
        }

        return false;
    }
}
