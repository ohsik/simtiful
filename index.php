<?php
/**
 * The main template file
 *
 * Simtiful 1.0.0
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 */

get_header(); ?>
    
    <!-- Main Banner
    -------------------------------------------------------------------------------------------------------------->
    <div class="main-banner">
        <div class="bodywrap">
            <div class="home-cta">
                <h1><?php bloginfo('name'); ?></h1>
                <p><?php bloginfo('description'); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Content
    -------------------------------------------------------------------------------------------------------------->
    <div class="bodywrap home-showcase">
        <div class="mansory">
        <?php
            while ( have_posts() ) : the_post();
                
                echo '<div class="grid6">';
                    // Include the page content template.
                    get_template_part( 'content', 'simple' );
                echo '</div>';
               
            // End the loop.
            endwhile;

        ?>
        </div>
    </div> <!-- END bodywrap -->
    
    <div class="bodywrap home-pgn">
        <?php 
            // Page navigation.
            simtiful_posts_nav_link(); 
        ?>
    </div>

<?php get_footer(); ?>