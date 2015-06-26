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
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );
	add_theme_support( 'custom-background', apply_filters( 'simtiful_custom_background_args', array(
		'default-color'      => '#fff',
		'default-attachment' => 'fixed',
	) ) );
	add_editor_style( array( 'css/editor-style.css', simtiful_fonts_url() ) );
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
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( '... Read more', 'your-text-domain' ) . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );