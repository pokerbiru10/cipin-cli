<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'CIPIN CLI v0.1 Released',
                'slug' => 'cipin-cli-v0-1-released',
                'description' => 'Highlights, fixes, and what to try first in the initial release.',
                'content' => 'Full content here...',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Prompting From The Terminal',
                'slug' => 'prompting-from-the-terminal',
                'description' => 'A practical workflow for iterating prompts quickly with repeatable runs.',
                'content' => 'Full content here...',
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Project Templates',
                'slug' => 'project-templates',
                'description' => 'How to start new AI tasks with consistent structure and less manual setup.',
                'content' => 'Full content here...',
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Using Providers & Keys',
                'slug' => 'using-providers-and-keys',
                'description' => 'Configure providers, environment variables, and safe local development.',
                'content' => 'Full content here...',
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
