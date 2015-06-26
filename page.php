<?php
/**
 * Page template
 */

get_header(); ?>
    
    <!-- Subpage Top - Breadcrumb & Search
    -------------------------------------------------------------------------------------------------------------->
    <div class="sub-banner">
        <div class="bodywrap">
            <div class="breadcrumb"><a href="index.html">
                Home</a> > Page Layout
            </div>
            <div class="search-top">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
    
    <!-- Content
    -------------------------------------------------------------------------------------------------------------->
    <div class="bodywrap main-content-wrap">
        <div class="row group"> 
            <div class="grid12">
                <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        // Include the page content template.
                        get_template_part( 'content', 'page' );

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                        echo '<div class="comment-wrap">';
                            comments_template();
                        echo '</div>';
                        endif;
                        

                    // End the loop.
                    endwhile;
                ?>
            </div>
        </div>
    </div> <!-- END bodywrap -->

<?php get_footer(); ?>