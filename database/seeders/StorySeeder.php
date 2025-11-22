<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = [
            [
                'name' => 'Eman Al-Hosary',
                'age' => 32,
                'location' => 'Gaza City, Palestine',
                'title' => 'A Mother\'s Love Never Dies',
                'content' => '<p class="lead fw-bold">A devoted mother, passionate teacher, and beacon of hope.</p>

<p>Eman Al-Hosary was more than just a name - she was a <strong>devoted mother of three children</strong> and a <strong>passionate educator</strong> who dedicated her entire life to shaping young minds in Gaza.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Her Legacy</p>
<p>Her home was a sanctuary filled with books, children\'s laughter, and endless dreams she nurtured for her family. Every corner told a story of love, dedication, and unwavering hope for a better tomorrow.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Final Day</p>
<p>On that fateful day, Eman was at home with her children, patiently helping them with their homework, when <strong>tragedy struck without warning</strong>. She died doing what she loved most - being there for her children.</p>

<p class="fst-italic text-muted mt-4">"Her smile could light up the darkest room, and her optimism was contagious. She truly believed her children would see a better tomorrow."</p>
<p class="text-end small">— Former colleague</p>',
                'story_type' => 'Personal Story',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'The Madi Family',
                'location' => 'Northern Gaza',
                'title' => 'A Family United in Love',
                'content' => '<p class="lead fw-bold">Mohammed, Fatima, and their five children - a family known for warmth, generosity, and unbreakable bonds.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Parents</p>
<p><strong>Mohammed</strong>, a skilled carpenter who crafted beautiful furniture, and <strong>Fatima</strong>, a talented seamstress teaching traditional Palestinian embroidery, built more than just a home - they created a haven of love and hope.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Children\'s Dreams</p>
<ul class="list-unstyled ms-3">
    <li class="mb-2">📚 <strong>Ahmad</strong> - Aspiring doctor, determined to heal his community</li>
    <li class="mb-2">✍️ <strong>Layla</strong> - Future journalist, passionate about storytelling</li>
    <li class="mb-2">🔢 <strong>Omar</strong> - Mathematics enthusiast with a brilliant mind</li>
    <li class="mb-2">👯 <strong>Sara & Samira</strong> - Inseparable twins who filled every room with giggles</li>
</ul>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Their Spirit</p>
<p>Known throughout their neighborhood as the family who <strong>never turned away a neighbor in need</strong>, they embodied the true spirit of community and compassion.</p>

<p class="fst-italic text-muted mt-4">"They always shared what little they had. Their door was always open, their table always welcoming."</p>',
                'story_type' => 'Family Story',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Baby Sila Al-Faseeh',
                'age' => 2,
                'location' => 'Khan Younis',
                'title' => 'An Innocent Soul',
                'content' => '<p class="lead fw-bold text-center">Just two years old. A lifetime of joy ahead. Gone in an instant.</p>

<p>Baby Sila Al-Faseeh was a <strong>bright-eyed toddler</strong> who had only just learned to speak in full sentences. Her world was simple and beautiful - colorful blocks, her mother\'s lullabies, and the tickles from her father that made her laugh uncontrollably.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">What Made Sila Special</p>
<p>Her <strong>infectious laugh</strong> could brighten even the darkest days. Curious and fearless, she explored every corner of their small home with wonder in her eyes, asking endless questions about the world she was just beginning to discover.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Her Favorite Moments</p>
<p>Grandmother braiding her soft dark hair while singing traditional Palestinian songs. Sharing toys at nursery with other children. Playing in the sunshine.</p>

<p class="bg-light p-3 rounded mt-4 border-start border-4 border-danger">
    <p class="mb-0 fst-italic"><strong>She represented the countless innocent children whose futures were stolen, whose laughter was silenced, and whose potential will never be realized.</strong></p>
</p>',
                'story_type' => 'Child Story',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Journalists of Gaza',
                'location' => 'Throughout Gaza Strip',
                'title' => 'Bearing Witness to Truth',
                'content' => '<p class="lead fw-bold">More than reporters. They were witnesses to history, guardians of truth.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Their Mission</p>
<p>Armed with <strong>cameras, notebooks, and unwavering courage</strong>, the journalists of Gaza documented reality often at great personal risk. They worked in impossible conditions - limited electricity, damaged equipment, constant danger.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Why They Stayed</p>
<p>They persisted because they believed <strong>the world needed to see</strong> and understand what was happening to their people. Many were killed while wearing press vests clearly marking them as journalists.</p>

<p class="bg-dark text-white p-4 rounded mt-4">
    <p class="mb-2"><strong class="text-uppercase">Names We Remember:</strong></p>
    <p class="mb-0">Shireen • Yaser • Roshdi • Hamza • And dozens more who gave their lives for truth</p>
</p>

<p class="fst-italic text-muted mt-4">"Their cameras captured images that shook the world. Their words gave voice to the suffering. Their sacrifice reminded us that journalism in conflict zones is not just a profession - it is an act of profound courage."</p>',
                'story_type' => 'Journalist',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Dr. Jihad Abu Amer',
                'age' => 45,
                'location' => 'Deir al-Balah',
                'title' => 'A Doctor\'s Dedication',
                'content' => '<p class="lead fw-bold">Over 20 years of service. The doctor who never said no.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">His Calling</p>
<p>Dr. Jihad Abu Amer was a <strong>general surgeon at Al-Aqsa Hospital</strong>, where colleagues described him as the doctor who never refused a patient, no matter the hour or how exhausted he was.</p>

<p>He studied medicine in Egypt and could have built a comfortable life elsewhere, but he chose to <strong>return to Gaza</strong> because he believed his skills were needed most at home.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">His Work</p>
<ul class="list-unstyled ms-3">
    <li class="mb-2">⚕️ Performed complex surgeries with limited resources</li>
    <li class="mb-2">👨‍⚕️ Trained younger doctors and mentored medical students</li>
    <li class="mb-2">📋 Documented cases to help future healthcare workers</li>
    <li class="mb-2">💪 Often worked 18-hour shifts without complaint</li>
</ul>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">At Home</p>
<p>A <strong>loving father to three daughters</strong> and devoted husband. Even after exhausting shifts, he would help his daughters with homework and never missed important family moments.</p>

<p class="bg-light p-3 rounded border-start border-4 border-primary">
    <p class="mb-0"><strong>He represented the countless healthcare workers who stayed at their posts when it would have been safer to flee.</strong></p>
</p>',
                'story_type' => 'Healthcare Worker',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Malak al-Qanoua',
                'age' => 7,
                'location' => 'Jabalia Refugee Camp',
                'title' => 'A Child\'s Innocent Joy',
                'content' => '<p class="lead fw-bold text-center">Her name means "Angel" - and everyone said it was perfect.</p>

<p><strong>Malak al-Qanoua</strong> was seven years old with bright eyes and a smile that could light up any room. Top of her class, she particularly excelled in art and mathematics.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Her Dreams</p>
<p>Malak wanted to become a <strong>doctor to help sick children</strong>. Her teacher kept a folder of her colorful drawings - families, flowers, and her dreams for the future.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Special Moments</p>
<p>Every morning, her grandfather walked her to school, telling stories about old Palestine. She had just learned to ride a bicycle and spent weekends practicing in the alley, her <strong>laughter echoing off the walls</strong>.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Her Kind Heart</p>
<p>Malak would save part of her allowance to buy treats for her younger siblings, showing generosity beyond her years. She had recently lost her first tooth and proudly displayed the gap in every photo.</p>

<p class="text-center fst-italic text-muted mt-4">"All the children whose childhoods were cut short, whose potential was never realized, whose dreams died with them."</p>',
                'story_type' => 'Child Story',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Shaaban Al-Dalou',
                'age' => 52,
                'location' => 'Central Gaza',
                'title' => 'A Teacher\'s Legacy',
                'content' => '<p class="lead fw-bold">30 years. Thousands of students. A lifetime of inspiration.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Ustaz Shaaban</p>
<p>Known affectionately as "Ustaz Shaaban" (Teacher Shaaban), he had taught mathematics for over <strong>30 years</strong>, inspiring generations of students in Gaza with his gift for making complex concepts understandable.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">Beyond The Classroom</p>
<ul class="list-unstyled ms-3">
    <li class="mb-2">📚 Bought supplies for students who couldn\'t afford them</li>
    <li class="mb-2">🎓 Ran free evening tutorials for university entrance exams</li>
    <li class="mb-2">👨‍🏫 Never turned away a child who wanted to learn</li>
    <li class="mb-2">💰 Used his own money to help struggling students</li>
</ul>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">At Home</p>
<p>A devoted grandfather who taught his grandchildren math through games and puzzles. He stayed up late preparing lessons, determined that <strong>every student would grasp the material</strong>.</p>

<p class="bg-success bg-opacity-10 p-4 rounded mt-4">
    <p class="mb-2 fw-bold">His Legacy Lives On</p>
    <p class="mb-0 small">Former students would return years later to thank him, crediting him with their academic and professional successes. He kept in touch with hundreds of them, celebrating their achievements as if they were his own children.</p>
</p>',
                'story_type' => 'Educator',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Saif Abu Warda',
                'age' => 16,
                'location' => 'Gaza City',
                'title' => 'A Teenager\'s Courage',
                'content' => '<p class="lead fw-bold">16 years old. Dreams bigger than the borders that confined him.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Student</p>
<p>Despite never having left Gaza, <strong>Saif Abu Warda</strong> was fascinated by the world beyond. He excelled in science and mathematics, hoping to study engineering or computer science at university.</p>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Leader</p>
<p>A natural leader among his peers:</p>
<ul class="list-unstyled ms-3">
    <li class="mb-2">📖 Organized study groups</li>
    <li class="mb-2">🎓 Tutored younger students</li>
    <li class="mb-2">⚽ Played football for his school team</li>
    <li class="mb-2">💻 Learning programming through online courses</li>
</ul>

<p class="text-uppercase small fw-semibold text-muted mt-4 mb-2">The Dreamer</p>
<p>Saif dreamed of creating apps to solve problems in Gaza. <strong>Mature beyond his years</strong>, he was incredibly close to his mother, helping with household chores and caring for his younger siblings.</p>

<p class="border border-dark border-2 p-3 mt-4">
    <p class="small text-uppercase fw-semibold mb-2">His Last Journal Entry:</p>
    <p class="mb-0 fst-italic">"I am determined to finish school and help rebuild Gaza. Nothing will stop me from making my community better."</p>
</p>',
                'story_type' => 'Youth Story',
                'status' => 'approved',
                'approved_at' => now(),
            ],
        ];

        foreach ($stories as $story) {
            Story::create($story);
        }
    }
}
