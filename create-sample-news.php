<?php
/**
 * Create Sample News Articles
 * Task 17: Configure blog/news functionality
 * 
 * This script creates sample news articles with proper categories
 * to demonstrate the blog/news functionality.
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

echo "========================================\n";
echo "Creating Sample News Articles\n";
echo "========================================\n\n";

// Get category IDs
$categories = array(
    'Academics' => get_term_by('name', 'Academics', 'category')->term_id,
    'Achievements' => get_term_by('name', 'Achievements', 'category')->term_id,
    'Events' => get_term_by('name', 'Events', 'category')->term_id,
    'General' => get_term_by('name', 'General', 'category')->term_id,
);

$sample_articles = array(
    array(
        'title' => 'Welcome to the New Academic Year 2024-2025',
        'content' => '<p>We are thrilled to welcome all our students, parents, and staff to the new academic year at Lumina International School. This year promises to be filled with exciting learning opportunities, innovative programs, and memorable experiences.</p>

<p>Our dedicated team of educators has been working tirelessly over the summer to prepare engaging curriculum and activities that will inspire and challenge our students. We look forward to seeing our students grow academically, socially, and spiritually throughout the year.</p>

<h3>What to Expect This Year</h3>

<ul>
<li>Enhanced STEM programs with new laboratory equipment</li>
<li>Expanded Islamic studies curriculum</li>
<li>New extracurricular activities including robotics and coding clubs</li>
<li>Improved sports facilities and programs</li>
<li>Regular parent-teacher engagement sessions</li>
</ul>

<p>We encourage all parents to stay connected with us through our website, newsletters, and parent-teacher meetings. Together, we can ensure the best educational experience for every child.</p>

<p>Here\'s to a successful and enriching academic year ahead!</p>',
        'category' => 'General',
        'excerpt' => 'We are thrilled to welcome all our students, parents, and staff to the new academic year at Lumina International School.',
        'date' => '2024-09-01 09:00:00',
    ),
    array(
        'title' => 'Grade 5 Students Excel in National Mathematics Competition',
        'content' => '<p>We are proud to announce that our Grade 5 students have achieved outstanding results in the National Mathematics Competition held last month. Three of our students secured top positions, bringing honor to our school and demonstrating the excellence of our mathematics program.</p>

<h3>Our Winners</h3>

<ul>
<li><strong>Sarah Ahmed</strong> - 1st Place (Gold Medal)</li>
<li><strong>Mohammed Ali</strong> - 2nd Place (Silver Medal)</li>
<li><strong>Fatima Hassan</strong> - 3rd Place (Bronze Medal)</li>
</ul>

<p>The competition featured over 200 students from schools across the region, making this achievement particularly impressive. Our students demonstrated exceptional problem-solving skills, mathematical reasoning, and composure under pressure.</p>

<h3>Preparation and Support</h3>

<p>This achievement is a testament to the hard work of our students and the dedication of our mathematics department. Our teachers provided additional coaching sessions, practice materials, and encouragement throughout the preparation period.</p>

<p>We congratulate all participants and encourage them to continue pursuing excellence in their academic endeavors. Special thanks to our mathematics teachers, Mr. Ahmed Khan and Ms. Aisha Rahman, for their outstanding guidance and support.</p>',
        'category' => 'Achievements',
        'excerpt' => 'Our Grade 5 students have achieved outstanding results in the National Mathematics Competition, with three students securing top positions.',
        'date' => '2024-10-15 10:30:00',
    ),
    array(
        'title' => 'New STEM Lab Opens for Hands-On Learning',
        'content' => '<p>Lumina International School is excited to announce the opening of our state-of-the-art STEM laboratory. This new facility represents a significant investment in our students\' future and will provide hands-on learning experiences in Science, Technology, Engineering, and Mathematics.</p>

<h3>Facility Features</h3>

<p>The STEM lab is equipped with:</p>

<ul>
<li>Modern computers with specialized software for coding and design</li>
<li>Robotics kits for building and programming robots</li>
<li>3D printers for prototyping and design projects</li>
<li>Interactive learning tools and educational technology</li>
<li>Science experiment stations with safety equipment</li>
<li>Collaborative workspaces for team projects</li>
</ul>

<h3>Educational Impact</h3>

<p>Students from all grade levels will have the opportunity to explore, experiment, and develop critical thinking skills through project-based learning. The lab will support our curriculum in multiple ways:</p>

<ul>
<li>Hands-on science experiments aligned with curriculum standards</li>
<li>Introduction to coding and computer programming</li>
<li>Robotics competitions and challenges</li>
<li>Design thinking and problem-solving projects</li>
<li>Integration with Islamic values and ethics in technology</li>
</ul>

<p>Our goal is to inspire the next generation of innovators and problem-solvers by providing them with the resources and guidance they need to excel in STEM fields.</p>

<p>The lab will be officially inaugurated next week with a special demonstration for parents and students.</p>',
        'category' => 'Academics',
        'excerpt' => 'Our new state-of-the-art STEM laboratory opens, providing students with hands-on learning experiences in Science, Technology, Engineering, and Mathematics.',
        'date' => '2024-11-05 14:00:00',
    ),
    array(
        'title' => 'Annual Sports Day Scheduled for Next Month',
        'content' => '<p>Mark your calendars! Our Annual Sports Day will be held on December 15th at the school sports field. This exciting event brings together students, parents, and staff for a day of friendly competition, physical activity, and school spirit.</p>

<h3>Event Details</h3>

<ul>
<li><strong>Date:</strong> December 15, 2024</li>
<li><strong>Time:</strong> 8:00 AM - 3:00 PM</li>
<li><strong>Location:</strong> School Sports Field</li>
<li><strong>Rain Date:</strong> December 16, 2024</li>
</ul>

<h3>Activities and Competitions</h3>

<p>Students will participate in various athletic events including:</p>

<ul>
<li>Sprint races (50m, 100m, 200m)</li>
<li>Relay competitions</li>
<li>Long jump and high jump</li>
<li>Team sports (football, basketball, volleyball)</li>
<li>Fun activities for younger students</li>
<li>Parent-child relay race</li>
</ul>

<h3>What to Bring</h3>

<p>Students should come prepared with:</p>

<ul>
<li>Comfortable athletic clothing and shoes</li>
<li>Water bottle</li>
<li>Sunscreen and hat</li>
<li>School spirit and enthusiasm!</li>
</ul>

<p>Parents are encouraged to attend and cheer for their children. Refreshments will be available throughout the day, and there will be shaded seating areas for spectators.</p>

<p>More details and the complete schedule will be shared with parents via email next week. We look forward to seeing everyone there!</p>',
        'category' => 'Events',
        'excerpt' => 'Our Annual Sports Day will be held on December 15th. Join us for a day of friendly competition and school spirit!',
        'date' => '2024-11-20 11:00:00',
    ),
    array(
        'title' => 'Parent-Teacher Conference Week Announced',
        'content' => '<p>We are pleased to announce that Parent-Teacher Conference Week will take place from December 10th to 14th. This is an important opportunity for parents to meet with teachers and discuss their child\'s progress, strengths, and areas for improvement.</p>

<h3>Conference Schedule</h3>

<ul>
<li><strong>Dates:</strong> December 10-14, 2024</li>
<li><strong>Times:</strong> 2:00 PM - 6:00 PM each day</li>
<li><strong>Duration:</strong> 15-20 minutes per conference</li>
<li><strong>Location:</strong> Individual classrooms</li>
</ul>

<h3>What Will Be Discussed</h3>

<p>During these conferences, teachers will share:</p>

<ul>
<li>Academic performance and progress reports</li>
<li>Social and behavioral observations</li>
<li>Strengths and areas for improvement</li>
<li>Recommendations for supporting learning at home</li>
<li>Answers to any questions or concerns</li>
<li>Goals for the remainder of the academic year</li>
</ul>

<h3>How to Schedule</h3>

<p>Parents can schedule their appointments through:</p>

<ul>
<li>Our online booking system (link sent via email)</li>
<li>Contacting the school office at (555) 123-4567</li>
<li>Sending a note with your child</li>
</ul>

<p>We encourage all parents to attend these conferences. Your involvement in your child\'s education is crucial to their success. If the scheduled times don\'t work for you, please contact us to arrange an alternative meeting time.</p>

<p>We look forward to meeting with all parents and working together to support our students\' success.</p>',
        'category' => 'General',
        'excerpt' => 'Parent-Teacher Conference Week will take place from December 10-14. Schedule your appointment today!',
        'date' => '2024-11-25 09:30:00',
    ),
    array(
        'title' => 'Islamic Studies Program Receives National Recognition',
        'content' => '<p>We are honored to announce that Lumina International School\'s Islamic Studies program has received national recognition from the Islamic Education Council for excellence in curriculum design and implementation.</p>

<h3>Recognition Highlights</h3>

<p>Our program was recognized for:</p>

<ul>
<li>Comprehensive Quranic studies curriculum</li>
<li>Integration of Islamic values across all subjects</li>
<li>Innovative teaching methodologies</li>
<li>Student engagement and understanding</li>
<li>Community involvement and outreach</li>
</ul>

<h3>Program Features</h3>

<p>Our Islamic Studies program includes:</p>

<ul>
<li>Daily Quran recitation and memorization</li>
<li>Islamic history and civilization studies</li>
<li>Character development based on Islamic principles</li>
<li>Arabic language instruction</li>
<li>Practical application of Islamic values in daily life</li>
</ul>

<p>This recognition validates our commitment to providing a holistic education that nurtures both academic excellence and spiritual growth. We are grateful to our dedicated Islamic Studies teachers and the entire school community for their support.</p>',
        'category' => 'Achievements',
        'excerpt' => 'Our Islamic Studies program receives national recognition for excellence in curriculum design and implementation.',
        'date' => '2024-11-28 13:00:00',
    ),
);

$created_count = 0;

foreach ($sample_articles as $article) {
    // Check if article already exists
    $existing = get_page_by_title($article['title'], OBJECT, 'post');
    
    if ($existing) {
        echo "   ℹ Article '{$article['title']}' already exists (ID: {$existing->ID})\n";
        continue;
    }
    
    $post_data = array(
        'post_title'    => $article['title'],
        'post_content'  => $article['content'],
        'post_excerpt'  => $article['excerpt'],
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_author'   => 1, // Admin user
        'post_date'     => $article['date'],
        'post_category' => array($categories[$article['category']]),
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (is_wp_error($post_id)) {
        echo "   ✗ Error creating article '{$article['title']}': " . $post_id->get_error_message() . "\n";
    } else {
        echo "   ✓ Created article '{$article['title']}' (ID: $post_id, Category: {$article['category']})\n";
        $created_count++;
    }
}

echo "\n========================================\n";
echo "Summary: Created $created_count new article(s)\n";
echo "========================================\n\n";

// Display all published posts
$all_posts = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
));

echo "Total published articles: " . $all_posts->found_posts . "\n\n";

echo "All articles:\n";
while ($all_posts->have_posts()) {
    $all_posts->the_post();
    $categories_list = array();
    $post_categories = get_the_category();
    foreach ($post_categories as $cat) {
        $categories_list[] = $cat->name;
    }
    
    echo "- " . get_the_title() . "\n";
    echo "  Date: " . get_the_date('F j, Y') . "\n";
    echo "  Categories: " . implode(', ', $categories_list) . "\n";
    echo "  URL: " . get_permalink() . "\n\n";
}

wp_reset_postdata();

echo "========================================\n";
echo "Sample news articles created successfully!\n";
echo "========================================\n";
