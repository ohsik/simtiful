<?php
if ( ! isset( $content_width ) ) {
	$content_width = 520;
}

if ( ! function_exists( 'simtiful_setup' ) ) :
function simtiful_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'simtiful' ),
		'secondary'  => __( 'Footer Menu', 'simtiful' ),
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	add_theme_support( 'custom-background', apply_filters( 'simtiful_custom_background_args', array(
		'default-color'      => '#fff',
		'default-attachment' => 'fixed',
	) ) );
	add_editor_style( array( 'css/editor-style.css', simtiful_fonts_url() ) );
    //enable translation
    load_theme_textdomain('simtiful', get_template_directory() . '/languages');
}
endif;
add_action( 'after_setup_theme', 'simtiful_setup' );


/**
 * Register widget area.
 */
function simtiful_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'simtiful' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'simtiful' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'simtiful_widgets_init' );


/**
 * Register Google fonts
 */
if ( ! function_exists( 'simtiful_fonts_url' ) ) :
function simtiful_fonts_url() {
	$fonts_url = '';
	$fonts     = array();

	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'simtiful' ) ) {
		$fonts[] = 'Open Sans:300italic,400italic,700italic,300,400,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;


/**
 * JavaScript Detection.
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function simtiful_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'simtiful_javascript_detection', 0 );


/**
 * Enqueue scripts and styles.
 */
function simtiful_scripts() {
	wp_enqueue_style( 'simtiful-fonts', simtiful_fonts_url(), array(), null );
    wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.min.css', array(), '3.0.3' );
	wp_enqueue_style( 'simtiful-style', get_stylesheet_uri() );
	wp_enqueue_style( 'simtiful-ie', get_template_directory_uri() . '/css/ie.css', array( 'simtiful-style' ), '20141010' );
	wp_style_add_data( 'simtiful-ie', 'conditional', 'lt IE 9' );
	wp_enqueue_style( 'simtiful-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'simtiful-style' ), '20141010' );
	wp_style_add_data( 'simtiful-ie7', 'conditional', 'lt IE 8' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ), '3.3.0', true );
	wp_enqueue_script( 'simtiful-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
    
}
add_action( 'wp_enqueue_scripts', 'simtiful_scripts' );




if ( ! function_exists( 'simtiful_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 */
function simtiful_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'simtiful' ) );
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'simtiful' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'simtiful' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
    
    if ( 'post' == get_post_type() ) {
        $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'simtiful' ) );
		if ( $categories_list && simtiful_categorized_blog() ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'simtiful' ),
				$categories_list
			);
		}
        
		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'simtiful' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'simtiful' ),
				$tags_list
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'simtiful' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'simtiful' ), __( '1 Comment', 'simtiful' ), __( '% Comments', 'simtiful' ) );
		echo '</span>';
	}
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function simtiful_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'simtiful_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'simtiful_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so simtiful_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so simtiful_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in {@see simtiful_categorized_blog()}.
 *
 * @since Twenty Fifteen 1.0
 */
function simtiful_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'simtiful_categories' );
}
add_action( 'edit_category', 'simtiful_category_transient_flusher' );
add_action( 'save_post',     'simtiful_category_transient_flusher' );

if ( ! function_exists( 'simtiful_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function simtiful_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()
}
endif;


if ( ! function_exists( 'simtiful_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 */
function simtiful_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<div class="navigation comment-navigation" role="navigation">
        <?php
            if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'simtiful' ) ) ) :
                printf( '<div class="nav-previous alignleft">%s</div>', $prev_link );
            endif;

            if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'simtiful' ) ) ) :
                printf( '<div class="nav-next alignright">%s</div>', $next_link );
            endif;
        ?>
	</div><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

/**
 * Excerpt length
 */
function custom_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Excerpt Readmore
 */
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( '... Read more', 'simtiful' ) . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


/*
 * WordPress Breadcrumbs
 * This breadcrumb script is licensed under MIT, https://gist.github.com/Dimox/5654092
 * Copyright (C) 2015 Dimox
*/
function simtiful_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = 'Category "%s"'; // text for a category page
	$text['search']   = 'Search Results for "%s"'; // text for a search results page
	$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
	$text['author']   = 'Articles Posted by %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page
	$text['page']     = 'Page %s'; // text 'Page N'
	$text['cpage']    = 'Comment Page %s'; // text 'Comment Page N'

	$delimiter      = '&rsaquo;'; // delimiter between crumbs
	$delim_before   = '<span class="divider">'; // tag before delimiter
	$delim_after    = '</span>'; // tag after delimiter
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_current   = 1; // 1 - show current page title, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link      = home_url('/');
	$link_before    = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
	$link_after     = '</span>';
	$link_attr      = ' itemprop="url"';
	$link_in_before = '<span itemprop="title">';
	$link_in_after  = '</span>';
	$link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
	$frontpage_id   = get_option('page_on_front');
	$parent_id      = $post->post_parent;
	$delimiter      = ' ' . $delim_before . $delimiter . $delim_after . ' ';

	if (is_home() || is_front_page()) {

		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumbs">';
		if ($show_home_link == 1) echo sprintf($link, $home_link, $text['home']);

		if ( is_category() ) {
			$cat = get_category(get_query_var('cat'), false);
			if ($cat->parent != 0) {
				$cats = get_category_parents($cat->parent, TRUE, $delimiter);
				$cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				if ($show_home_link == 1) echo $delimiter;
				echo $cats;
			}
			if ( get_query_var('paged') ) {
				$cat = $cat->cat_ID;
				echo $delimiter . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_current == 1) echo $delimiter . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			}

		} elseif ( is_search() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ($show_home_link == 1) echo $delimiter;
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0 || get_query_var('cpage')) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ( get_query_var('cpage') ) {
					echo $delimiter . sprintf($link, get_permalink(), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
				} else {
					if ($show_current == 1) echo $before . get_the_title() . $after;
				}
			}

		// custom post type
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			if ( get_query_var('paged') ) {
				echo $delimiter . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_current == 1) echo $delimiter . $before . $post_type->label . $after;
			}

		} elseif ( is_attachment() ) {
			if ($show_home_link == 1) echo $delimiter;
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			if ($cat) {
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($show_home_link == 1) echo $delimiter;
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			if ($show_current == 1) echo $delimiter . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
			if ($show_home_link == 1) echo $delimiter;
			global $author;
			$author = get_userdata($author);
			echo $before . sprintf($text['author'], $author->display_name) . $after;

		} elseif ( is_404() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo $before . $text['404'] . $after;

		} elseif ( has_post_format() && !is_singular() ) {
			if ($show_home_link == 1) echo $delimiter;
			echo get_post_format_string( get_post_format() );
		}

		echo '</div><!-- .breadcrumbs -->';

	}
} // end simtiful_breadcrumbs()


/*
 * Numbered Pagination
*/
if ( !function_exists( 'simtiful_posts_nav_link' ) ) {
	
	function simtiful_posts_nav_link() {
		
		$prev_arrow = is_rtl() ? '&rarr;' : '&larr;';
		$next_arrow = is_rtl() ? '&larr;' : '&rarr;';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );
		}
	}
	
}

/*
 * Theme options
*/
require get_template_directory() . '/inc/customizer.php';