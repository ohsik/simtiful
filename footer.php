    <!-- Footer
    -------------------------------------------------------------------------------------------------------------->
    <footer class="footer">
        <div class="bodywrap">
            <nav>
                <ul>
                    <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
                </ul>
            </nav>
            <p><?php echo wp_kses_post(get_theme_mod( 'copyright_textbox', 'Simtiful 2015 powered by WordPress.' )); ?></p>
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>