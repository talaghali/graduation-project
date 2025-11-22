<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Highlight;

class HighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing highlights
        Highlight::truncate();

        $highlights = [
            [
                'title' => 'Voices of Gaza - Documentary',
                'description' => 'A powerful documentary showcasing the stories of resilience and hope from Gaza.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Children of Gaza: Stories of Survival',
                'description' => 'Young voices sharing their experiences and dreams for a better future.',
                'video_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Gaza: A Historical Perspective',
                'description' => 'Understanding the rich history and culture of Gaza through the ages.',
                'video_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Life Under Siege',
                'description' => 'Daily life stories from families living in Gaza.',
                'video_url' => 'https://www.youtube.com/watch?v=YQHsXMglC9A',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Hope in the Darkness',
                'description' => 'Stories of hope, courage, and determination from the people of Gaza.',
                'video_url' => 'https://www.youtube.com/watch?v=3JZ_D3ELwOQ',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Gaza Fishermen - A Way of Life',
                'description' => 'Following the daily routines of Gaza\'s fishing community.',
                'video_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => false,
                'order' => 6,
            ],
            [
                'title' => 'Medical Heroes of Gaza',
                'description' => 'Healthcare workers sharing their experiences and challenges.',
                'video_url' => 'https://www.youtube.com/watch?v=lXMskKTw3Bc',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => true,
                'order' => 7,
            ],
            [
                'title' => 'Artists of Gaza',
                'description' => 'Creative expression and art as a form of resistance and hope.',
                'video_url' => 'https://www.youtube.com/watch?v=RgKAFK5djSk',
                'video_type' => 'youtube',
                'thumbnail_path' => null, // Auto-generated from YouTube
                'is_active' => false,
                'order' => 8,
            ],
        ];

        foreach ($highlights as $highlight) {
            Highlight::create($highlight);
        }

        $this->command->info('✓ ' . count($highlights) . ' highlight videos seeded successfully!');
    }
}
