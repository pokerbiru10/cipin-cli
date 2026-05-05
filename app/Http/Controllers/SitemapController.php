<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap for search engines
     */
    public function index(): Response
    {
        // Static pages
        $staticPages = [
            [
                'url' => route('home'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'url' => route('blog'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'url' => route('products'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'url' => route('docs'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
        ];

        // Blog posts (same as in blog.blade.php)
        $posts = [
            ['slug' => 'cipin-cli-v0-1-released', 'date' => '2026-04-29'],
            ['slug' => 'prompting-from-the-terminal', 'date' => '2026-04-27'],
            ['slug' => 'project-templates', 'date' => '2026-04-25'],
            ['slug' => 'using-providers-and-keys', 'date' => '2026-04-23'],
            ['slug' => 'logging-and-debugging-runs', 'date' => '2026-04-21'],
            ['slug' => 'working-with-files', 'date' => '2026-04-19'],
            ['slug' => 'batch-jobs', 'date' => '2026-04-17'],
            ['slug' => 'cost-and-token-hygiene', 'date' => '2026-04-15'],
            ['slug' => 'cli-ux-tips', 'date' => '2026-04-13'],
            ['slug' => 'agents-and-tools', 'date' => '2026-04-11'],
            ['slug' => 'local-dev-setup', 'date' => '2026-04-09'],
            ['slug' => 'roadmap-preview', 'date' => '2026-04-07'],
        ];

        $blogPages = collect($posts)->map(function ($post) {
            return [
                'url' => route('detail-news', ['slug' => $post['slug']]),
                'lastmod' => $post['date'],
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        })->toArray();

        $urls = array_merge($staticPages, $blogPages);

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate robots.txt
     */
    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "\n";
        $content .= "Sitemap: " . route('sitemap') . "\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
