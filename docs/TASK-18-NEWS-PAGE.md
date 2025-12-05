# Task 18: Build News Page with Article Listing

## Overview
This document provides detailed information about the News page implementation for Lumina International School website, including technical specifications, usage instructions, and customization options.

## Requirements Addressed
- **Requirement 11.1**: Display articles in reverse chronological order
- **Requirement 11.2**: Show featured images, titles, dates, and excerpts
- **Requirement 11.3**: Display featured images for each news article
- **Requirement 11.5**: Implement category filtering

## Technical Implementation

### 1. Shortcodes Created

#### Category Filter Shortcode
```php
[lumina_news_categories]
```

**Function**: `lumina_news_categories_shortcode()`
**Location**: `wp-content/themes/lumina-child-theme/functions.php`

**Features**:
- Displays "All News" button
- Shows individual category filter buttons
- Highlights active category
- Responsive button layout
- Brand color styling

**Output Structure**:
```html
<div class="lumina-news-categories">
  <div class="category-filter-buttons">
    <a href="..." class="category-filter-btn active">All News</a>
    <a href="..." class="category-filter-btn">Academics</a>
    <a href="..." class="category-filter-btn">Achievements</a>
    <a href="..." class="category-filter-btn">Events</a>
    <a href="..." class="category-filter-btn">General</a>
  </div>
</div>
```

#### News Grid Shortcode
```php
[lumina_news_grid posts_per_page="9"]
```

**Function**: `lumina_news_grid_shortcode($atts)`
**Location**: `wp-content/themes/lumina-child-theme/functions.php`

**Parameters**:
- `posts_per_page` (optional): Number of articles per page (default: 9)
- `category` (optional): Filter by category slug

**Features**:
- Reverse chronological ordering
- Responsive CSS Grid layout
- Featured images with placeholder fallback
- Category badges
- Article metadata (date, author)
- Excerpts
- "Read Full Article" links
- Pagination support
- Empty state message

**Output Structure**:
```html
<div class="lumina-news-grid">
  <article class="news-grid-card">
    <div class="news-card-image">
      <a href="..."><img src="..." alt="..."></a>
      <span class="news-category-badge">Category</span>
    </div>
    <div class="news-card-content">
      <h3 class="news-card-title"><a href="...">Title</a></h3>
      <div class="news-card-meta">
        <span class="news-card-date">Date</span>
        <span class="news-card-author">Author</span>
      </div>
      <div class="news-card-excerpt">Excerpt...</div>
      <a href="..." class="news-card-read-more">Read Full Article</a>
    </div>
  </article>
  <!-- More articles... -->
</div>
<div class="lumina-news-pagination">
  <!-- Pagination links -->
</div>
```

### 2. Page Configuration

**Page Details**:
- Page ID: 29
- Page Slug: `news`
- Page URL: `/news/`
- Template: Elementor Header/Footer
- Elementor: Enabled

**Elementor Structure**:
1. **Section 1**: Full-width section with light gray background
   - **Column 1**: Single column (100% width)
     - Heading widget: "News & Announcements"
     - Text editor widget: Subtitle/description
     - Spacer widget: 30px
     - Shortcode widget: `[lumina_news_categories]`
     - Spacer widget: 30px
     - Shortcode widget: `[lumina_news_grid]`

### 3. CSS Styling

#### Category Filter Styles
```css
.lumina-news-categories {
  background: #FFFFFF;
  padding: 25px 30px;
  border-radius: 12px;
  margin-bottom: 40px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.category-filter-btn {
  padding: 12px 24px;
  background: #f7f7f7;
  color: #003d70;
  border-radius: 25px;
  font-size: 15px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.category-filter-btn:hover {
  background: #7EBEC5;
  color: #FFFFFF;
}

.category-filter-btn.active {
  background: #003d70;
  color: #FFFFFF;
}
```

#### News Grid Styles
```css
.lumina-news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 30px;
}

.news-grid-card {
  background: #FFFFFF;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.news-grid-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
}
```

#### Responsive Breakpoints
```css
@media (max-width: 768px) {
  .lumina-news-grid {
    grid-template-columns: 1fr;
  }
  
  .category-filter-buttons {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .news-card-image {
    height: 200px;
  }
}
```

## Usage Instructions

### For Content Editors

#### Adding News Articles:
1. Go to **Posts → Add New** in WordPress admin
2. Enter article title
3. Write article content using the editor
4. Select category (Academics, Achievements, Events, General)
5. Set featured image (recommended: 800x600px)
6. Write or auto-generate excerpt
7. Click **Publish**

#### Managing Categories:
1. Go to **Posts → Categories**
2. View, edit, or add new categories
3. Assign descriptions to categories

#### Viewing the News Page:
1. Navigate to `/news/` on the website
2. See all published articles
3. Use category filter buttons to filter by topic
4. Click article cards to read full content

### For Developers

#### Customizing Shortcode Output:

**Change posts per page**:
```php
[lumina_news_grid posts_per_page="12"]
```

**Filter by category**:
```php
[lumina_news_grid category="academics"]
```

**Combine parameters**:
```php
[lumina_news_grid posts_per_page="6" category="events"]
```

#### Modifying Styles:

Override shortcode styles in your theme's CSS:

```css
/* Custom news grid styles */
.lumina-news-grid {
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

/* Custom category button styles */
.category-filter-btn {
  padding: 15px 30px;
  font-size: 16px;
}
```

#### Programmatic Usage:

```php
// Get news grid output
$news_grid = do_shortcode('[lumina_news_grid posts_per_page="6"]');
echo $news_grid;

// Get category filter output
$categories = do_shortcode('[lumina_news_categories]');
echo $categories;
```

## Design Specifications

### Colors
- **Primary**: #003d70 (base-darkblue) - Titles, active states
- **Secondary**: #7EBEC5 (base-accent-teal) - Icons, hover effects
- **Accent**: #F39A3B (base-accent-orange) - CTAs, badges
- **Background**: #f7f7f7 (base-lightgray) - Page background
- **White**: #FFFFFF (base-white) - Cards, buttons

### Typography
- **Page Title**: 42px, bold
- **Article Titles**: 20px, bold
- **Body Text**: 15-16px, regular
- **Meta Text**: 13px, regular
- **Button Text**: 15px, semi-bold

### Spacing
- **Card Padding**: 25px
- **Grid Gap**: 30px
- **Section Margin**: 40px
- **Element Spacing**: 15-20px

### Shadows
- **Card Shadow**: 0 2px 15px rgba(0, 0, 0, 0.08)
- **Card Hover Shadow**: 0 8px 25px rgba(0, 61, 112, 0.15)
- **Badge Shadow**: 0 2px 8px rgba(0, 0, 0, 0.2)

### Transitions
- **Duration**: 0.3s
- **Easing**: ease
- **Properties**: all, transform, color, background

## Integration Points

### With Task 17 (Blog/News Functionality):
- Uses archive.php template for category pages
- Uses single.php template for individual articles
- Displays articles created in Task 17
- Uses categories created in Task 17

### With Homepage:
- Homepage uses `[lumina_recent_news]` shortcode
- News page uses `[lumina_news_grid]` shortcode
- Both display same articles, different layouts

### With Navigation:
- News page accessible from main menu
- Category links navigate to filtered views
- Breadcrumbs show navigation path

## Testing Checklist

### Functional Testing:
- [ ] News page loads without errors
- [ ] Category filter buttons display correctly
- [ ] "All News" button shows all articles
- [ ] Category buttons filter articles correctly
- [ ] Active category is highlighted
- [ ] Articles display in reverse chronological order
- [ ] Featured images display (or placeholder)
- [ ] Article titles are clickable
- [ ] Dates and authors display correctly
- [ ] Excerpts display correctly
- [ ] "Read Full Article" links work
- [ ] Pagination appears when needed
- [ ] Pagination links work correctly

### Visual Testing:
- [ ] Layout looks professional
- [ ] Brand colors are consistent
- [ ] Hover effects work smoothly
- [ ] Shadows and spacing are correct
- [ ] Typography is readable
- [ ] Images scale properly

### Responsive Testing:
- [ ] Desktop layout (1920px+)
- [ ] Laptop layout (1024px-1920px)
- [ ] Tablet layout (768px-1024px)
- [ ] Mobile layout (320px-768px)
- [ ] Portrait and landscape orientations
- [ ] Touch interactions work on mobile

### Browser Testing:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers

## Troubleshooting

### Issue: Shortcodes not working
**Solution**: Ensure functions.php has been updated with the new shortcode functions. Clear WordPress cache.

### Issue: Articles not displaying
**Solution**: Check that articles are published (not draft). Verify post type is 'post'.

### Issue: Category filter not working
**Solution**: Ensure categories are assigned to posts. Check that category slugs are correct.

### Issue: Pagination not appearing
**Solution**: Pagination only appears when there are more posts than posts_per_page setting.

### Issue: Styles not applying
**Solution**: Clear browser cache and WordPress cache. Check that CSS is included in shortcode output.

### Issue: Featured images not showing
**Solution**: Ensure featured images are set on posts. Placeholder will be used if no image is set.

## Performance Optimization

### Query Optimization:
- Uses WP_Query with proper pagination
- Limits posts per page to prevent large queries
- Uses efficient ordering (date DESC)

### CSS Optimization:
- Inline CSS included with shortcodes
- Minimal CSS footprint
- Uses CSS Grid for efficient layouts

### Image Optimization:
- Uses registered image size (lumina-news: 800x600)
- WordPress native lazy loading
- Placeholder for missing images

### Caching:
- Compatible with WordPress caching plugins
- No dynamic JavaScript required
- Static HTML output

## Future Enhancements

### Potential Improvements:
1. **AJAX Filtering**: Load articles without page reload
2. **Search Functionality**: Add search bar to filter articles
3. **Tags Support**: Implement tags for more granular categorization
4. **Featured Posts**: Add ability to feature/pin important articles
5. **Reading Time**: Display estimated reading time
6. **Social Sharing**: Add share buttons to article cards
7. **Load More**: Implement "Load More" button instead of pagination
8. **Infinite Scroll**: Auto-load more articles on scroll

### Advanced Features:
1. **Newsletter Integration**: Add email subscription
2. **RSS Feed**: Ensure RSS feed is properly configured
3. **Social Media Auto-Post**: Auto-post to social media when publishing
4. **Related Articles**: Show related articles on single posts
5. **Print Styles**: Add print-friendly CSS

## Conclusion

Task 18 has been successfully completed. The News page provides a professional, user-friendly interface for displaying school news and announcements with all required features:

- ✓ Reverse chronological ordering
- ✓ Featured images with placeholder fallback
- ✓ Complete article information
- ✓ Category filtering
- ✓ Pagination support
- ✓ "Read More" links
- ✓ Responsive design
- ✓ Brand-consistent styling

The implementation is production-ready and fully integrated with the existing WordPress infrastructure.
