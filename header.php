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
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
<![endif]-->
    
<?php wp_head(); ?>

<?php /* Favicon uncomment this to enable
<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicon.png">
*/ ?>
</head>

<body <?php body_class(); ?>>
    <!-- Header
    -------------------------------------------------------------------------------------------------------------->
    <header class="header bodywrap">
        <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo.png" /></a></div>
        <div class="main-nav">
            <input type="checkbox" id="onav" />
            <label for="onav" class="onav-btn"></label>
            <nav>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container' => '' ) ); ?>
            </nav>
        </div>
    </header>