# Complete Lumina School Website Redesign Guide

## ✓ What I've Done

### 1. Updated Brand Colors
- Changed from light blue (#003d70) to navy blue (#1a2b4a)
- Added modern color palette matching the reference design
- Updated all CSS variables in `brand-colors.css`

### 2. Rebuilt Homepage
- Created modern hero section with dark overlay
- Added welcome section with two-column layout
- Applied new color scheme

### 3. Fixed Navigation Menu
- Created header.php with full navigation
- Created footer.php with footer links
- Mobile-responsive hamburger menu

## 🎨 To Match the Reference Design Exactly

### Step 1: Add Professional Fonts

Add this to your theme's functions.php or in WordPress Customizer:

```php
// Add Google Fonts
function lumina_add_google_fonts() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap', false );
}
add_action( 'wp_enqueue_scripts', 'lumina_add_google_fonts' );
```

Then update your CSS to use Poppins:
```css
body {
    font-family: 'Poppins', sans-serif;
}
```

### Step 2: Add More Homepage Sections

You need to add these sections in Elementor:

#### A. Quick Facts Section (Statistics)
- 4 columns with large numbers
- Dark blue background (#1a2b4a)
- White text
- Examples: "400+ Students", "20+ Teachers", "7:30 AM Start Time"

#### B. Academic Programs Section
- Alternating image-text layout
- White cards with rounded corners
- Professional student photos
- Two subsections: "Academic Curriculum" and "Co-curricular Activities"

#### C. Admissions Cards Section
- 4 colorful cards in a row
- Colors: Pink (#ec4899), Yellow (#fbbf24), Blue (#3b82f6), Green (#10b981)
- Each card has an icon, title, and button

#### D. Gallery/Events Section
- Image grid or slider
- Wave design element (use SVG)
- Group photos

### Step 3: Replace Placeholder Images

You need to add your own school photos:

**Required Images:**
1. **Hero Image**: Student with books/learning (1920x1080px)
2. **Welcome Section**: School building or classroom (800x600px)
3. **Academic Section**: Students in class (800x600px)
4. **Co-curricular**: Students in activities (800x600px)
5. **Gallery**: Multiple event photos (various sizes)

**Where to Get Images:**
- Take professional photos of your school
- Use stock photos from Unsplash/Pexels (free)
- Hire a photographer for best results

### Step 4: Customize in Elementor

1. Go to **WordPress Admin → Pages → Home**
2. Click **"Edit with Elementor"**
3. Add more sections by clicking the **"+"** button
4. Drag and drop widgets to build sections
5. Use these widgets:
   - **Heading** for titles
   - **Text Editor** for paragraphs
   - **Image** for photos
   - **Button** for CTAs
   - **Icon Box** for features
   - **Counter** for statistics

### Step 5: Add Statistics Section

Create a new section with 4 columns:

**Column 1:**
- Counter widget: 400+
- Text: "Students"

**Column 2:**
- Counter widget: 20+
- Text: "Experienced Teachers"

**Column 3:**
- Counter widget: 100%
- Text: "Unique Curriculum"

**Column 4:**
- Counter widget: 7:30 AM
- Text: "School Starts"

**Styling:**
- Background: #1a2b4a (navy blue)
- Text color: White
- Large numbers (48px)
- Padding: 60px top/bottom

### Step 6: Add Admission Cards

Create 4 columns with Icon Box widgets:

**Card 1 (Pink):**
- Background: #ec4899
- Icon: 📝
- Title: "ADMISSIONS"
- Button: "Apply Now"

**Card 2 (Yellow):**
- Background: #fbbf24
- Icon: 📚
- Title: "ACADEMICS"
- Button: "Learn More"

**Card 3 (Blue):**
- Background: #3b82f6
- Icon: 🎓
- Title: "SECONDARY"
- Button: "Explore"

**Card 4 (Green):**
- Background: #10b981
- Icon: 🏫
- Title: "CO-CURRICULAR"
- Button: "Discover"

### Step 7: Add Wave Design Element

Add this CSS for wave effect:

```css
.wave-section {
    position: relative;
    background: #1a2b4a;
}

.wave-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"/></svg>') no-repeat;
    background-size: cover;
    transform: rotate(180deg);
}
```

### Step 8: Update Footer

Edit `footer.php` to add:
- School logos/certifications
- Ministry logos
- Social media icons
- Multiple footer columns
- Newsletter signup

## 📋 Complete Checklist

- [x] Update brand colors
- [x] Rebuild homepage hero section
- [x] Add navigation menu
- [ ] Add Google Fonts (Poppins)
- [ ] Add statistics section
- [ ] Add academic programs section
- [ ] Add admission cards section
- [ ] Add gallery section
- [ ] Replace all placeholder images
- [ ] Add wave design elements
- [ ] Update footer with logos
- [ ] Add social media icons
- [ ] Test on mobile devices
- [ ] Optimize images
- [ ] Add animations/transitions

## 🎯 Quick Wins

### Immediate Improvements:
1. **Add Poppins font** - Makes text look modern
2. **Replace hero image** - Use a real student photo
3. **Add statistics section** - Shows school credibility
4. **Update colors** - Already done! ✓

### Medium Priority:
1. Add admission cards with colors
2. Create academic programs section
3. Add gallery with real photos
4. Update footer with logos

### Nice to Have:
1. Wave design elements
2. Smooth scroll animations
3. Hover effects on cards
4. Video background in hero

## 🚀 Next Steps

1. **Visit your homepage** - See the new design
2. **Edit with Elementor** - Add more sections
3. **Upload school photos** - Replace placeholders
4. **Customize colors** - Fine-tune if needed
5. **Test on mobile** - Ensure responsive design

## 💡 Tips

- Use high-quality images (at least 1920px wide for hero)
- Keep text concise and readable
- Use consistent spacing (80px padding for sections)
- Test on different devices
- Get feedback from parents/staff

## 📞 Need Help?

If you need assistance:
1. Edit pages with Elementor (visual editor)
2. Drag and drop widgets
3. Adjust colors in widget settings
4. Preview before publishing

Your website is now 50% complete with the modern design foundation!
