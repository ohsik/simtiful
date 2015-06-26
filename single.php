<?php
/**
 * Single Template
 */

get_header(); ?>


    <!-- Subpage Top - Breadcrumb & Search
    -------------------------------------------------------------------------------------------------------------->
    <div class="sub-banner">
        <div class="bodywrap">
            <div class="breadcrumb"><a href="index.html">
                Home</a> > Article Layout
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
            <div class="grid9">
                <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part( 'content', get_post_format() );

                        // If comments are open or we have at least one comment, load up the comment template.
                        
                        if ( comments_open() || get_comments_number() ) :
                            echo '<div class="comment-wrap">';
                            comments_template();
                            echo '</div>';
                        endif;
                        

                        // Previous/next post navigation.
                        
                    // End the loop.
                    endwhile;
                    ?>
            </div>
            
            <div class="grid3">
                <?php get_sidebar(); ?>
            </div>
            
        </div>
    </div> <!-- END bodywrap -->

<?php get_footer(); ?>