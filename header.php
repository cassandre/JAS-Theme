<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JaS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jas' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="logo-nav">
            <div class="site-logo">
                <?php the_custom_logo(); ?>
            </div>
            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'jas' ); ?></button>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                ) );
                ?>
            </nav><!-- #site-navigation -->
        </div>

        <div class="banner">
            <?php print get_header_image_tag(); ?>
            <div class="site-branding">
                <?php
                if ( is_front_page() && is_home() ) :
                    ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
                else :
                    ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                endif;
                if (is_front_page()) :
                    $jas_description = get_bloginfo( 'description', 'display' );
                    if ( $jas_description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo $jas_description; /* WPCS: xss ok. */ ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div><!-- .site-branding -->
        </div>
        <?php  if (is_front_page()) : ?>
            <aside id="front-page-boxes" class="widget-area">
                <?php dynamic_sidebar( 'front-page-boxes' ); ?>
            </aside>
        <?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
