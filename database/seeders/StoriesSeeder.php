<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = [
            [
                'user_id' => 1,
                'name' => 'Layla Hassan',
                'age' => 28,
                'location' => 'Gaza City',
                'title' => 'A Mother\'s Hope Amidst the Ruins',
                'content' => 'My name is Layla, and I am a mother of three beautiful children. Our home was destroyed in the bombardment, but we survived. Every day I wake up grateful that my children are alive. We now live in a temporary shelter, but I teach my children to never lose hope. I tell them stories of our beautiful Gaza, of the sea, and of better days to come. They draw pictures of our old home and dream of rebuilding it one day.',
                'story_type' => 'Personal Experience',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Ahmed Khalil',
                'age' => 45,
                'location' => 'Rafah',
                'title' => 'The Teacher Who Never Stopped Teaching',
                'content' => 'I have been a teacher for 20 years. When our school was damaged, I didn\'t stop. I gathered children under the olive trees and continued their lessons. Education is hope, and hope is what keeps us alive. Even without books or proper materials, we learn. The children\'s eagerness to study despite everything inspires me every day. They deserve a future, and I will do everything to help them achieve it.',
                'story_type' => 'Education',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Fatima Abed',
                'age' => 35,
                'location' => 'Khan Younis',
                'title' => 'Baking Bread in Times of Crisis',
                'content' => 'I am Fatima, a baker. When flour became scarce, I found ways to make bread for my neighbors. Every loaf I bake is an act of resistance and solidarity. I see the smiles on children\'s faces when they eat warm bread, and it gives me strength to continue. My small bakery became a gathering place where people share stories and support each other. In these difficult times, we hold onto our humanity.',
                'story_type' => 'Community Support',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Omar Mansour',
                'age' => 52,
                'location' => 'Jabalia',
                'title' => 'A Doctor\'s Duty',
                'content' => 'As a doctor in Gaza, every day presents impossible choices. With limited supplies and overwhelming need, we do our best to save lives. I have seen courage beyond measure in my patients. Children who smile despite their pain, parents who sacrifice everything for their families. Working 18-hour shifts is exhausting, but knowing that each life saved is a victory keeps me going. Medicine is not just my profession; it is my calling and my resistance.',
                'story_type' => 'Healthcare',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Nour Ali',
                'age' => 19,
                'location' => 'Gaza City',
                'title' => 'Dreams of a Young Journalist',
                'content' => 'I am 19 years old and I want to be a journalist. I document our daily lives with my phone camera because the world needs to know our truth. I film the resilience of my people, the children playing amidst rubble, the women cooking with whatever they can find. Every video I share is a testament to our existence and our refusal to be forgotten. Despite the danger, I will continue to tell our stories.',
                'story_type' => 'Media & Documentation',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Yousef Salah',
                'age' => 41,
                'location' => 'Deir al-Balah',
                'title' => 'The Fisherman\'s Tale',
                'content' => 'The sea has always been my life. My father was a fisherman, his father before him. The restrictions make it harder now, but I still go out when I can. The sea doesn\'t judge or discriminate. It provides for those who respect it. I teach my sons the ways of the sea, hoping that one day they will fish in peace. Every fish I catch feeds not just my family, but several neighbors. We share everything we have.',
                'story_type' => 'Livelihood',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Mariam Issa',
                'age' => 67,
                'location' => 'Gaza City',
                'title' => 'Memories of Old Gaza',
                'content' => 'I have lived in Gaza all my life. I remember when the streets were full of life and laughter, when children played freely, and families gathered for celebrations. Those memories sustain me now. I share stories with my grandchildren about the beautiful Gaza I knew, the markets, the culture, the joy. I want them to know that Gaza was and will be again a place of beauty and peace. We are not just survivors; we are keepers of history.',
                'story_type' => 'Cultural Heritage',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Mahmoud Zaki',
                'age' => 33,
                'location' => 'Beit Hanoun',
                'title' => 'An Engineer\'s Determination',
                'content' => 'I am an engineer, and I use my skills to help rebuild what was destroyed. With limited resources, we find creative solutions. I design water collection systems, repair damaged buildings, and help neighbors restore their homes. Each project is a small victory against despair. My colleagues and I work together, sharing knowledge and tools. We believe that Gaza will rise again, stronger and more beautiful than before.',
                'story_type' => 'Reconstruction',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Samira Nasr',
                'age' => 24,
                'location' => 'Gaza City',
                'title' => 'Art as Resistance',
                'content' => 'I am an artist. When words fail, I paint. My canvases show the beauty and pain of Gaza, the resilience of our people, the hope in children\'s eyes. Art is my weapon and my healing. I teach art to children in shelters, giving them a way to express their feelings and dreams. Through colors and brushes, they find moments of peace. Every painting is a declaration that we are here, we are alive, and we will not be silenced.',
                'story_type' => 'Arts & Culture',
                'status' => 'approved',
            ],
            [
                'user_id' => 1,
                'name' => 'Saeed Ibrahim',
                'age' => 38,
                'location' => 'Rafah',
                'title' => 'The Shopkeeper\'s Generosity',
                'content' => 'I run a small shop in Rafah. Business is difficult, but I try to help my community. I give credit to those who cannot pay, share food with those who have none, and keep my shop open as a place where people can gather and feel safe. In times like these, profit means nothing compared to solidarity. My shop is more than a business; it is a community center where we support each other and share news, food, and hope.',
                'story_type' => 'Community Support',
                'status' => 'approved',
            ],
        ];

        foreach ($stories as $storyData) {
            Story::create($storyData);
        }

        $this->command->info('Successfully created 10 new stories!');
    }
}
