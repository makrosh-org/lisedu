<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </h1>
            <?php
            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) :
                ?>
                <p class="site-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>

        <nav class="main-navigation" role="navigation" aria-label="Primary Navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" aria-label="Toggle mobile menu" aria-expanded="false">
            <span class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>
</header>

<style>
/* Header Styles */
.site-header {
    background: #FFFFFF;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 20px 0;
    border-bottom: none;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.site-branding {
    flex: 0 0 auto;
}

.site-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    line-height: 1.2;
}

.site-title a {
    color: var(--base-darkblue, #003d70);
    text-decoration: none;
}

.site-title a:hover {
    color: var(--base-accent-teal, #7EBEC5);
}

.site-description {
    margin: 5px 0 0;
    font-size: 14px;
    color: #666;
}

/* Navigation Menu */
.main-navigation {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

.primary-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 5px;
}

.primary-menu li {
    position: relative;
}

.primary-menu > li > a {
    display: block;
    padding: 10px 15px;
    color: var(--base-darkblue, #003d70);
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: color 0.3s ease;
}

.primary-menu > li > a:hover,
.primary-menu > li.current-menu-item > a {
    color: #f59e0b;
    text-decoration: none;
}

/* Dropdown Menus */
.primary-menu .sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #FFFFFF;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    list-style: none;
    margin: 0;
    padding: 10px 0;
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
}

.primary-menu li:hover > .sub-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.primary-menu .sub-menu li {
    display: block;
}

.primary-menu .sub-menu a {
    display: block;
    padding: 10px 20px;
    color: var(--base-darkblue, #003d70);
    text-decoration: none;
    font-size: 14px;
    transition: background 0.3s ease;
}

.primary-menu .sub-menu a:hover {
    background: var(--base-lightgray, #f7f7f7);
    color: var(--base-accent-teal, #7EBEC5);
}

/* Mobile Menu Toggle */
.mobile-menu-toggle {
    display: none;
}

/* Mobile Styles */
@media (max-width: 768px) {
    .header-container {
        flex-wrap: wrap;
    }
    
    .site-branding {
        flex: 1;
    }
    
    .mobile-menu-toggle {
        display: block;
        background: var(--base-darkblue, #003d70);
        color: var(--base-white, #FFFFFF);
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 18px;
        border-radius: 5px;
    }
    
    .main-navigation {
        display: none;
        flex-basis: 100%;
        order: 3;
        margin-top: 15px;
    }
    
    .main-navigation.active {
        display: block;
    }
    
    .primary-menu {
        flex-direction: column;
        gap: 0;
    }
    
    .primary-menu li {
        border-bottom: 1px solid var(--base-lightgray, #f7f7f7);
    }
    
    .primary-menu > li > a {
        padding: 15px 10px;
    }
    
    .primary-menu .sub-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        padding-left: 20px;
        display: none;
    }
    
    .primary-menu li.menu-open > .sub-menu {
        display: block;
    }
}
</style>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.main-navigation');
    
    if (toggle && nav) {
        toggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            const isExpanded = nav.classList.contains('active');
            toggle.setAttribute('aria-expanded', isExpanded);
        });
    }
    
    // Mobile submenu toggle
    const menuItems = document.querySelectorAll('.primary-menu .menu-item-has-children > a');
    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.parentElement.classList.toggle('menu-open');
            }
        });
    });
});
</script>
