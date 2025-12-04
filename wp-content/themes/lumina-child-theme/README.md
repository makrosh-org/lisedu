# Lumina International School Child Theme

A custom WordPress child theme for Lumina International School with brand-specific styling and functionality.

## Version
1.0.0

## Parent Theme
Twenty Twenty-Four (or Hello Elementor/Astra when installed)

## Features

### Brand Colors
The theme implements the official Lumina International School brand color palette:
- **Base Dark Blue**: #003d70 (Primary color)
- **Base Light Gray**: #f7f7f7 (Background color)
- **Base Accent Teal**: #7EBEC5 (Secondary color)
- **Base Accent Orange**: #F39A3B (Accent color)
- **Base White**: #FFFFFF

All colors are defined as CSS variables in `assets/css/brand-colors.css` for consistent usage across the site.

### Custom Image Sizes
The theme registers custom image sizes optimized for the school website:
- **Hero Images**: 1920x1080px
- **Gallery Images**: 1200x800px
- **Gallery Thumbnails**: 400x300px
- **Team Photos**: 600x600px
- **News Featured Images**: 800x600px

### Custom Scripts
The theme includes custom JavaScript functionality:
- Mobile menu toggle
- Smooth scrolling for anchor links
- Enhanced form validation with real-time feedback
- Lazy loading fallback for older browsers

### Theme Support
- Custom logo support
- Post thumbnails
- HTML5 markup
- Title tag

## Installation

1. Ensure the parent theme (Twenty Twenty-Four, Hello Elementor, or Astra) is installed
2. Upload the `lumina-child-theme` folder to `/wp-content/themes/`
3. Activate the child theme from WordPress admin (Appearance > Themes)
4. Upload the school logo via Appearance > Customize > Site Identity

## File Structure

```
lumina-child-theme/
├── style.css                    # Theme metadata and main stylesheet
├── functions.php                # Theme functions and customizations
├── README.md                    # This file
├── assets/
│   ├── css/
│   │   └── brand-colors.css    # Brand color variables and styling
│   ├── js/
│   │   └── custom-scripts.js   # Custom JavaScript functionality
│   └── images/
│       └── logo.svg            # School logo
└── templates/                   # Custom page templates (if needed)
```

## Customization

### Adding Custom Styles
Add custom CSS to `style.css` or create new CSS files in `assets/css/` and enqueue them in `functions.php`.

### Modifying Brand Colors
Edit the CSS variables in `assets/css/brand-colors.css`. All components using these variables will automatically update.

### Adding Custom Scripts
Add JavaScript to `assets/js/custom-scripts.js` or create new JS files and enqueue them in `functions.php`.

### Creating Custom Templates
Add custom page templates to the `templates/` directory and they will be available in the WordPress page editor.

## Requirements
- WordPress 6.4+
- PHP 8.1+
- Parent theme (Twenty Twenty-Four, Hello Elementor, or Astra)

## Support
For questions or issues, contact the Lumina International School web team.

## License
GNU General Public License v2 or later
