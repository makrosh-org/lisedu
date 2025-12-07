
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Lumina International School</h3>
                <p>Nurturing Young Minds with Islamic Values and Academic Excellence</p>
                <p><strong>📧 Email:</strong> info@luminaschool.edu<br>
                <strong>📞 Phone:</strong> (123) 456-7890<br>
                <strong>📍 Address:</strong> 123 Education Street, City</p>
                
                <div class="footer-social">
                    <h4>Connect With Us</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook" title="Facebook">📘</a>
                        <a href="#" aria-label="Twitter" title="Twitter">🐦</a>
                        <a href="#" aria-label="Instagram" title="Instagram">📷</a>
                        <a href="#" aria-label="LinkedIn" title="LinkedIn">💼</a>
                        <a href="#" aria-label="YouTube" title="YouTube">📺</a>
                    </div>
                </div>
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
            
            <div class="footer-column">
                <h4>Important Links</h4>
                <nav>
                    <ul class="footer-menu">
                        <li><a href="/admissions">Admissions</a></li>
                        <li><a href="/programs">Programs</a></li>
                        <li><a href="/events">Events</a></li>
                        <li><a href="/contact">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Lumina International School. All rights reserved. | Designed with ❤️ for Education</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>