<?php
/**
 * Header file for the Bloglog WordPress theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bloglog
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
if( function_exists('wp_body_open') ){
    wp_body_open();
} ?>


<?php bloglog_header_banner_section(); ?>


<?php $bloglog_default = bloglog_get_default_theme_options();
$ed_preloader = get_theme_mod( 'ed_preloader', $bloglog_default['ed_preloader'] );
if ($ed_preloader) { ?>
    <div class="preloader hide-no-js <?php if( isset( $_COOKIE['MasonryGridNightDayMode'] ) && $_COOKIE['MasonryGridNightDayMode'] == 'true' ){ echo 'preloader-night-mode'; } ?>">
        <div class="loader">
            <span></span><span></span><span></span><span></span>
        </div>
    </div>
<?php } ?>

<?php $ed_cursor_option = get_theme_mod( 'ed_cursor_option', $bloglog_default['ed_cursor_option'] );
if ($ed_cursor_option) { ?>
    <div class="theme-custom-cursor theme-cursor-primary"></div>
    <div class="theme-custom-cursor theme-cursor-secondary"></div>
<?php } ?>


<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to the content', 'bloglog'); ?></a>

    <header id="site-header" class="theme-site-header" role="banner">
        <?php get_template_part('template-parts/header/header', 'content'); ?>
    </header>

    <div id="content" class="site-content">

        <?php if( is_home() || is_front_page() ){ bloglog_carousel_section(); bloglog_archive_log_section(); bloglog_about_section(); } ?>