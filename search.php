<?php
/**
 * Category Template
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
    <div class="bodywrap main-content-wrap article-list">
        <div class="row group"> 
            <div class="grid12">
                <?php if ( have_posts() ) : ?>
                    <article>
                        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'simtiful' ), get_search_query() ); ?></h1>
                    </article>
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post(); ?>

                        <?php
                        /*
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part( 'content', 'simple' );

                    // End the loop.
                    endwhile;

                    // Previous/next page navigation.
                    the_posts_pagination( array(
                        'prev_text'          => __( 'Previous page', 'simtiful' ),
                        'next_text'          => __( 'Next page', 'simtiful' ),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'simtiful' ) . ' </span>',
                    ) );

                // If no content, include the "No posts found" template.
                else :
                    get_template_part( 'content', 'none' );

                endif;
                ?>
            </div>
        </div>
    </div> <!-- END bodywrap -->

<?php get_footer(); ?>