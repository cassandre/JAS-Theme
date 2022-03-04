<?php
/**
 * The sidebar containing the footer widget areas
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JaS
 */
?>

<div class="site-info">
    <aside id="sidebar-info-area" class="widget-area">
        <?php dynamic_sidebar( 'sidebar-info-area' ); ?>
    </aside><!-- #sidebar-info-area -->
</div><!-- .site-info -->

<div class="site-info-sub">
    <aside id="sidebar-footer" class="widget-area">
        <?php dynamic_sidebar( 'sidebar-footer' ); ?>
    </aside><!-- #sidebar-info-area -->
</div><!-- .site-info -->



