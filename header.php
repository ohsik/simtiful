<?php
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
<!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5shiv.min.js"></script>
<![endif]-->
    
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    <!-- Header
    -------------------------------------------------------------------------------------------------------------->
    <header class="header bodywrap">
        <div class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <?php if ( get_theme_mod( 'simtiful_logo' ) || get_theme_mod( 'simtiful_logo' ) != '' ) : ?>
                <img src="<?php echo esc_url( get_theme_mod( 'simtiful_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<?php else: ?>
								<?php bloginfo('name'); ?>
            <?php endif; ?>
            </a>
        </div>
        <div class="main-nav">
            <input type="checkbox" id="onav" />
            <label for="onav" class="onav-btn"><span class="nav-icon"></span></label>
            <nav>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
            </nav>
        </div>
    </header>