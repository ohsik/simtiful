    <!-- Footer
    -------------------------------------------------------------------------------------------------------------->
    <footer class="footer">
        <div class="bodywrap">
            <nav>
                <ul>
                    <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
                </ul>
            </nav>
            <p>&#169; 2015. All rights reserved.</p>
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>