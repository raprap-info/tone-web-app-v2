<?php
/**
 * Header Layout 1
 *
 * @package Bloglog
 */
$bloglog_default = bloglog_get_default_theme_options();
$ed_desktop_menu = get_theme_mod( 'ed_desktop_menu',$bloglog_default['ed_desktop_menu'] );
?>


<div class="wrapper">
    <div class="wrapper-inner">

        <div class="header-component header-component-left">
            <div class="header-titles">

                <?php
                // Site title or logo.
                bloglog_site_logo();
                // Site description.
                bloglog_site_description();
                ?>

            </div><!-- .header-titles -->
        </div><!-- .header-component-left -->

        <div class="header-component header-component-right">
            <?php if( $ed_desktop_menu ){ ?>

                <div class="navbar-components">
                    <div class="site-navigation">
                        <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e('Horizontal', 'bloglog'); ?>" role="navigation">

                            <ul class="primary-menu">

                                <?php
                                if( has_nav_menu('bloglog-primary-menu') ){

                                    wp_nav_menu(
                                        array(
                                            'container' => '',
                                            'items_wrap' => '%3$s',
                                            'theme_location' => 'bloglog-primary-menu',
                                        )
                                    );

                                }else{

                                    wp_list_pages(
                                        array(
                                            'match_menu_classes' => true,
                                            'show_sub_menu_icons' => true,
                                            'title_li' => false,
                                            'walker' => new Bloglog_Walker_Page(),
                                        )
                                    );

                                } ?>

                            </ul>

                        </nav><!-- .primary-menu-wrapper -->
                    </div><!-- .site-navigation -->
                </div>

            <?php } ?>
            <div class="navbar-controls hide-no-js">

                <?php
                $ed_day_night_mode_switch = get_theme_mod( 'ed_day_night_mode_switch', $bloglog_default['ed_day_night_mode_switch'] );
                if( $ed_day_night_mode_switch ){ ?>

                    <button type="button" class="navbar-control theme-action-control navbar-day-night navbar-day-on">
                        <span class="action-control-trigger day-night-toggle-icon" tabindex="-1">
                            <span class="moon-toggle-icon">
                                <i class="moon-icon">
                                    <?php bloglog_the_theme_svg('moon'); ?>
                                </i>
                            </span>

                            <span class="sun-toggle-icon">
                                <i class="sun-icon">
                                    <?php bloglog_the_theme_svg('sun'); ?>
                                </i>
                            </span>
                        </span>
                    </button>

                <?php }

                $ed_header_search = get_theme_mod('ed_header_search', $bloglog_default['ed_header_search']);
                if ($ed_header_search) { ?>

                    <button type="button" class="navbar-control theme-action-control navbar-control-search">
                         <span class="action-control-trigger" tabindex="-1">
                            <?php bloglog_the_theme_svg('search'); ?>
                         </span>
                    </button>

                <?php } ?>

                <button type="button" class="navbar-control theme-action-control navbar-control-offcanvas">
                     <span class="action-control-trigger" tabindex="-1">
                        <?php bloglog_the_theme_svg('menu'); ?>
                     </span>
                </button>

            </div>

        </div><!-- .header-component-right -->

    </div>
</div>
