<?php
/**
 * The sidebar containing the main widget area
 */

if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
    <div id="widget-area" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>
<?php endif; ?>
