
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Lumina International School</h3>
                <p>Nurturing Young Minds with Islamic Values</p>
                <p>Email: info@luminaschool.edu<br>
                Phone: (123) 456-7890</p>
            </div>
            
            <div class="footer-column">
                <h4>Quick Links</h4>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => 'nav',
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Lumina International School. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<style>
/* Footer Styles */
.site-footer {
    background: var(--base-darkblue, #003d70);
    color: #FFFFFF;
    padding: 40px 0 20px;
    margin-top: 60px;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 30px;
}

.footer-column h3,
.footer-column h4 {
    color: #FFFFFF;
    margin-bottom: 15px;
}

.footer-column p {
    color: #FFFFFF;
    line-height: 1.6;
    margin: 10px 0;
}

.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin: 8px 0;
}

.footer-menu a {
    color: #FFFFFF;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-menu a:hover {
    color: var(--base-accent-teal, #7EBEC5);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 20px;
    text-align: center;
}

.footer-bottom p {
    margin: 0;
    color: #FFFFFF;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
</style>

</body>
</html>
