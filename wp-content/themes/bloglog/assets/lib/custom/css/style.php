<?php
/**
 * Bloglog Dynamic Styles
 *
 * @package Bloglog
 */

function bloglog_dynamic_css()
{

    $bloglog_default = bloglog_get_default_theme_options();
    $background_color = get_theme_mod('background_color', $bloglog_default['background_color']);

    $background_color = '#'.str_replace("#","",$background_color);

    $bloglog_primary_color = get_theme_mod('bloglog_primary_color', $bloglog_default['bloglog_primary_color']);
    $bloglog_secondary_color = get_theme_mod('bloglog_secondary_color', $bloglog_default['bloglog_secondary_color']);
    $bloglog_general_color = get_theme_mod('bloglog_general_color', $bloglog_default['bloglog_general_color']);
    
    $logo_width_range = get_theme_mod('logo_width_range', $bloglog_default['logo_width_range']);
    
    $heade_banner_height_range = get_theme_mod('heade_banner_height_range', $bloglog_default['heade_banner_height_range']);

    echo "<style type='text/css' media='all'>"; ?>
    .theme-header-banner {
        height : <?php echo esc_attr($heade_banner_height_range); ?>px;

    }


    .site-logo .custom-logo{
    max-width:  <?php echo esc_attr($logo_width_range); ?>px;
    }

    body.theme-color-schema,
    .preloader,
    .floating-post-navigation .floating-navigation-label,
    .header-searchbar-inner,
    .offcanvas-wraper{
    background-color: <?php echo esc_attr($background_color); ?>;
    }

    body.theme-color-schema,
    body,
    .floating-post-navigation .floating-navigation-label,
    .header-searchbar-inner,
    .offcanvas-wraper{
        color: <?php echo esc_attr($bloglog_general_color); ?>;
    }

    .preloader .loader span{
        background: <?php echo esc_attr($bloglog_general_color); ?>;
    }
    a{
        color: <?php echo esc_attr($bloglog_primary_color); ?>;
    }
  

    body .theme-page-vitals,
    body .site-navigation .primary-menu > li > a:before,
    body .site-navigation .primary-menu > li > a:after,
    body .site-navigation .primary-menu > li > a:after,
    body .site-navigation .primary-menu > li > a:hover:before,
    body .entry-thumbnail .trend-item,
    body .category-widget-header .post-count{
        background: <?php echo esc_attr($bloglog_secondary_color); ?>;
    }
    
    body a:hover,
    body a:focus,
    body .footer-credits a:hover,
    body .footer-credits a:focus,
    body .widget a:hover,
    body .widget a:focus {
        color: <?php echo esc_attr($bloglog_secondary_color); ?>;
    }
    body input[type="text"]:hover,
    body input[type="text"]:focus,
    body input[type="password"]:hover,
    body input[type="password"]:focus,
    body input[type="email"]:hover,
    body input[type="email"]:focus,
    body input[type="url"]:hover,
    body input[type="url"]:focus,
    body input[type="date"]:hover,
    body input[type="date"]:focus,
    body input[type="month"]:hover,
    body input[type="month"]:focus,
    body input[type="time"]:hover,
    body input[type="time"]:focus,
    body input[type="datetime"]:hover,
    body input[type="datetime"]:focus,
    body input[type="datetime-local"]:hover,
    body input[type="datetime-local"]:focus,
    body input[type="week"]:hover,
    body input[type="week"]:focus,
    body input[type="number"]:hover,
    body input[type="number"]:focus,
    body input[type="search"]:hover,
    body input[type="search"]:focus,
    body input[type="tel"]:hover,
    body input[type="tel"]:focus,
    body input[type="color"]:hover,
    body input[type="color"]:focus,
    body textarea:hover,
    body textarea:focus,
    button:focus,
    body .button:focus,
    body .wp-block-button__link:focus,
    body .wp-block-file__button:focus,
    body input[type="button"]:focus,
    body input[type="reset"]:focus,
    body input[type="submit"]:focus{
        border-color:  <?php echo esc_attr($bloglog_secondary_color); ?>;
    }
    body .theme-page-vitals:after {
        border-right-color:  <?php echo esc_attr($bloglog_secondary_color); ?>;
    }
    body a:focus,
    body .theme-action-control:focus > .action-control-trigger,
    body .submenu-toggle:focus > .btn__content{
        outline-color:  <?php echo esc_attr($bloglog_secondary_color); ?>;
    }
    <?php echo "</style>";
}

add_action('wp_head', 'bloglog_dynamic_css', 100);

/**
 * Sanitizing Hex color function.
 */
function bloglog_sanitize_hex_color($color)
{

    if ('' === $color)
        return '';
    if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color))
        return $color;

}